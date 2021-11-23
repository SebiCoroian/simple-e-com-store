<?php
require_once "ShoppingCart.php";?>
<HTML>
<HEAD>
    <TITLE>Creare cos cumparaturi </TITLE>
    <link href="style.css" type="text/css" rel="stylesheet"/>
</HEAD>
<BODY style="background-color:#5CDB95;" >
<div class="header">
  <a href="#default" class="logo">MagazinSticle</a>
  <div class="header-right">
    <a class="active" href="magazin.php">produse</a>
    <a href="cos.php">cos</a>
     <?php 
    if (isset($_SESSION['loggedin'])) 
    echo "<a href=\"logout.php\">logout</a>";
    else
    echo "<a href=\"Index.html\">login</a>";
    ?>
  </div>
</div> 



<!-- <table>
  <tr>
    <th>All<input type=hidden id='schimba' name='categorie' value='categorie'></th>
    <th>Recipiente standard <input type=hidden id='schimba' name='cat1' value='cat1'></th>
    <th>Recipiente XL<input type=hidden id='schimba' name='cat2' value='cat2'></th>
  </tr>
<table>

MACAR AM INCERCAT

aici era un script php sa dau post la o variabila cu valoarea din tag-u de input pentru categorie
apoi urma sa mai bag un if jos in funtie de acea valoare sa dea display fie la toate produsele
fie la categoria continuta in variabila
> -->



<div id="product-grid">
    <div class="txt-heading"><h1 style="color:#05386B;">Produse:</h1></div>
    <?php
    $shoppingCart = new ShoppingCart();
    $query = "SELECT * FROM tbl_product";
    $product_array = $shoppingCart->getAllProduct($query);
    if (! empty($product_array)) {
        foreach ($product_array as $key => $value) {
            ?>
            <div class="product-item">
                <form method="post" action="Cos.php?action=add&code=<?php
                echo $product_array[$key]["code"]; ?>">
                <table>
                    <tr>
                   <th> <div class="product-image">
                        <img src="<?php echo $product_array[$key]["image"]; ?>" style="border-radius: 20%;">
                    </div>
                    <th>
                        <th> <h3 style="color:#05386B;"><?php echo $product_array[$key]["descriere"]; ?></h3></th>
                </tr>
            </table>
                    <div>
                        <strong style="color:#05386B;"><?php echo $product_array[$key]["name"]; ?></strong>
                    </div>
                    <div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
                    <div>
                        <input type="text" name="quantity" value="1" size="2" />
                        <input type="submit" value="Add to cart"
                               class="btnAddAction" />
                    </div>
                </form>
            </div>
            <?php
        }
    }
    ?>
</div>
</BODY>
</HTML>