<?php
// Schimbați acest lucru cu informațiile despre conexiune.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = "";
$DATABASE_NAME = 'proiect';
// Incerc sa ma conectez pe baza info de mai sus.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
// Dacă există o eroare la conexiune, opriți scriptul și afișați eroarea.
    exit('Nu se poate conecta la MySQL: ' . mysqli_connect_error());
}
//.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
// Nu s-au putut obține datele care ar fi trebuit trimise.
exit('Complare formular registration !');
}
// Asigurați-vă că valorile înregistrării trimise nu sunt goale.
if (empty($_POST['username']) || empty($_POST['password']) ||
empty($_POST['email'])) {
// One or more values are empty.
exit('Completare registration form');
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    exit('Email nu este valid!');
}
if (preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0) {
    exit('Username nu este valid!');
}
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
    exit('Password trebuie sa fie intre 5 si 20 charactere!');
}
// verificam daca contul userului exista.
if ($stmt = $con->prepare('SELECT id, password FROM users WHERE username = ?')) {
// hash parola folosind funcția PHP password_hash.
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
// Memoram rezultatul, astfel încât să putem verifica dacă contul există în baza de date.
if ($stmt->num_rows > 0) {
// Username exista
echo 'Username exists, alegeti altul!';
} else {
        if ($stmt = $con->prepare('INSERT INTO users (username, password, email) VALUES (?, ?, ?)')) {
// Nu dorim să expunem parole în baza noastră de date, așa că hash parola și utilizați //password_verify atunci când un utilizator se conectează.
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
$stmt->execute();
echo 'Success inregistrat!';
header('Location: Index.html');
} else {
// Ceva nu este în regulă cu declarația sql, verificați pentru a vă asigura că tabelul conturilor //există cu toate cele 3 câmpuri.
echo 'Nu se poate face prepare statement!';
}
}
$stmt->close();
} else {
// Ceva nu este în regulă cu declarația sql, verificați pentru a vă asigura că tabelul conturilor //există cu toate cele 3 câmpuri.
echo 'Nu se poate face prepare statement!';
}
$con->close();
?>