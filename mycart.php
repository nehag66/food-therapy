<?php
require_once('src/helpers/DbConnection.php');
require_once('src/repository/ItemsRepository.php');
// Starting session.
session_start();

// Checking if user is already loggedin
$isLoggedIn = isset($_SESSION['username']) && is_string($_SESSION['username']);

if ($isLoggedIn === false) {
    header('Loction: index.php');
    return;
}

$cartItems = ($isLoggedIn & isset($_SESSION['cart']) & !empty($_SESSION['cart'])) ? $_SESSION['cart'] : [];

$obj = DbConnection::getNewConnectionObj();
$itemsRepo = new ItemsRepository($obj->getConnection());

$itemsInfo = $itemsRepo->getItemsDetail(array_keys($cartItems));

?>
<!DOCTYPE html>
<html>
<?php include "header.php" ?>
<body>
    <?php include 'navbar.php' ?>
    <br>
    <br>
    <h1 align="center"> REVIEW YOUR ORDER </h1> <br> <br>
    <h1 style="margin-left:1em" ;> ITEMS YOU HAVE SELECTED</h1>


    <div style="padding-left: 30px;">
        <div>
            <img src="images/golgappe.jpg" style="width:20%;">
        </div>
        Qty <br>
        <!-- Quantity -->
        <div>
            <button type="button">-</button>
            <input id="prodQuantity" type="text" name="quantity" value="700"/>
            <button type="button">+</button>
        </div>
        <!-- /Quantity -->

        Price <br>
        24

        <br>
        <button class="place_order">PLACE ORDER</button>
    </div>

    <?php
    if (!empty($cartItems)) {
        $noItems = count($cartItems);

        for ($key = 0; $key < $noItems; $key++) {
            $item = $cartItems[$key];

            $itemHtml = '';
            if ((($key + 1) % 4) === 1) {

                $itemHtml .= '<div class="row">';
            }

            $itemHtml .=
                "<div class=\"column\">
                        <img src=\"".$item["image_url"]."\">
                        <div>
                            <b align = 'right'>".$item['name']."</b>
                        </div>
                        <div>
                            <b align = 'right'>".$item['price']."</b>
                        </div>"
            ;

            if (isset($cartItems[$item['id']])) {
                $itemHtml .= "<a type=\"btn\" href='addtocart.php?item=".$item['id']."&qty=-1'>-</a>";
                $itemHtml .= "<input type='number' value='".$cartItems[$item['id']]."' name ='qty_".$item['id'].
                    "' min='0' max='3' style='width: 13%;' disabled = 'disabled'/>";
                $itemHtml .= "<a type=\"btn\" href='addtocart.php?item=".$item['id']."&qty=1'>+</a>";
            }

            if ($isLoggedIn) {
                $itemHtml .=
                    "<div>
                            <a type=\"btn\" href='addtocart.php?item=".$item['id']."&qty=1'>Add to cart</a>
                        </div>";
            } else {
                $itemHtml .=
                    "<div>
                            <button type=\"button\" onclick='alert(\"SignIn to add to Cart\");'>Add to cart</button>
                        </div>";
            }

            $itemHtml .= "</div>";
            if ((($key + 1) % 4) === 0 || $noItems === ($key + 1)) {
                $itemHtml .= "</div>";
            }

            echo $itemHtml;
        }
    }
    ?>

</body>
</html>