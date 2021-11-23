<?php
require_once "ShoppingCart.php";
session_start();
// Dacă utilizatorul nu este conectat redirecționează la pagina de autentificare ...
if (!isset($_SESSION['loggedin'])) {
    header('Location: Index.html');
    exit;
}
// pt membrii inregistrati
$id_member=$_SESSION['loggedin'];
$shoppingCart = new ShoppingCart();
if (! empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
 if (! empty($_POST["quantity"])) {

     $productResult = $shoppingCart->getProductByCode($_GET["code"]);

 $cartResult = $shoppingCart->getCartItemByProduct($productResult[0]["id"], $id_member);

 if (! empty($cartResult)) {
     // Modificare cantitate in cos
     $newQuantity = $cartResult[0]["quantity"] + $_POST["quantity"];
     $shoppingCart->updateCartQuantity($newQuantity, $cartResult[0]["id"]);
 } else {
     // Adaugare in tabelul cos
     $shoppingCart->addToCart($productResult[0]["id"], $_POST["quantity"], $id_member);
 }
 }
 break;
        case "remove":
            // Sterg o sg inregistrare
            $shoppingCart->deleteCartItem($_GET["id"]);
            break;
        case "empty":
            // Sterg cosul
            $shoppingCart->emptyCart($id_member);
            break;
    }
}
?>


<HTML>
<HEAD>
    <div class="header">
  <a href="#default" class="logo">MagazinSticle</a>
  <div class="header-right">
    <a href="magazin.php">produse</a>
    <a class="active" href="cos.php">cos</a>
    <?php 
    if (isset($_SESSION['loggedin'])) 
    echo "<a href=\"logout.php\">logout</a>";
    else
    echo "<a href=\"Index.html\">login</a>";
    ?>
  </div>
</div> 
    <TITLE>Creare cos permament in PHP</TITLE>
    <link href="style.css" type="text/css" rel="stylesheet" />
</HEAD>
<BODY style="background-color:#5CDB95;">
<div id="shopping-cart">
    <div class="txt-heading">
        <div class="txt-heading-label"><b>Cos Cumparaturi</b></div>
        <a id="btnEmpty" href="Cos.php?action=empty"><img src="<img src=" alt="empty-cart" title="Empty Cart" /></a>
    </div>
    <?php
    $cartItem = $shoppingCart->getMemberCartItem($id_member);
    if (!empty($cartItem)) {
        $item_total = 0;
        ?>
        <table cellpadding="10" cellspacing="1">
            <tbody>
            <tr>
                <th style="text-align: left;"><strong>Name</strong></th>
                <th style="text-align: left;"><strong>Code</strong></th>
                <th style="text-align:
right;"><strong>Quantity</strong></th>
                <th style="text-align:
right;"><strong>Price</strong></th>
                <th style="text-align:
center;"><strong>Action</strong></th>
            </tr>
            <?php
            foreach ($cartItem as $item) {
                ?>
                <tr>
                    <td
                        style="text-align: left; border-bottom: #F0F0F0 1px solid;"><strong><?php echo $item["name"]; ?></strong></td>
                    <td
                        style="text-align: left; border-bottom: #F0F0F0 1px solid;"><?php echo $item["code"]; ?></td>
                    <td
                        style="text-align: right; border-bottom: #F0F0F0 1px solid;"><?php echo $item["quantity"]; ?></td>
                    <td
                        style="text-align: right; border-bottom: #F0F0F0 1px solid;"><?php echo "$".$item["price"]; ?></td>
                    <td
                        style="text-align: center; border-bottom: #F0F0F0 1px solid;"><a href="Cos.php?action=remove&id=<?php echo $item["cart_id"]; ?>"
                            class="btnRemoveAction"><img src="icon-delete.png" alt="icon-delete" title="Remove Item" /></a></td>
                </tr>
                <?php
                $item_total += ($item["price"] * $item["quantity"]);
            }
            ?>
            <tr>
                <td colspan="3"
                    align=right><strong>Total:</strong></td>
                <td align=right><?php echo "$".$item_total; ?></td>
                <td></td>
            </tr>
            </tbody>
        </table>
        <?php
    }
    ?>
</div>
<div ><a href="magazin.php">Alegeti alt produs</a></div>
<div><a href="logout.php">Abandonati sesiunea de cumparare</a></div>
<?php //require_once "product-list.php"; ?>

</BODY>
</HTML>
