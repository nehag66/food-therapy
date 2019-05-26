<?php
require_once('src/helpers/DbConnection.php');
require_once('src/repository/ItemsRepository.php');

// Starting session.
session_start();

// Checking if user is already loggedin
$isLoggedIn = isset($_SESSION['username']) && is_string($_SESSION['username']);

$obj = DbConnection::getNewConnectionObj();
$itemsRepo = new ItemsRepository($obj->getConnection());

$foodItems = $itemsRepo->getPaginationItems('FOOD', 1, 100);

$cartItems = ($isLoggedIn & isset($_SESSION['cart']) & !empty($_SESSION['cart'])) ? $_SESSION['cart'] : [];

?>

<html>
<?php include "header.php"?>
<body>
    <?php include 'navbar.php'?>

    <div class="text">
        <h4><u>FOOD CORNER</u></h4>
    </div>
    <div style="padding-right:10px;float: right;" class="topnav2">
        <?php
            if (true === $isLoggedIn) {
                echo "<button type=\"button\" class=\"signup\" 
style=\"background-color: green;width: 100%\" onclick=\"location.href='mycart.php'\">Checkout Now</button>";
            }
        ?>
    </div>
    <br><br>
    <br><br>
    <div>
        <?php
        if (!empty($foodItems) && !empty($foodItems['FOOD'])) {
            $noItems = count($foodItems['FOOD']);
            foreach ($foodItems['FOOD'] as $key => $item) {
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
    </div>
    <br>
    <br><br>
</body>
</html>