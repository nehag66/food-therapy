<?php
require_once('src/helpers/DbConnection.php');
require_once('src/repository/ItemsRepository.php');
// Starting session.
session_start();

// Checking if user is already loggedin
$isLoggedIn = isset($_SESSION['username']) && is_string($_SESSION['username']);

if (!$isLoggedIn) {
    header('Location: index.php');
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
    <div class="container">
        <h1 align="center"> REVIEW YOUR ORDER </h1> <br> <br>
        <h1 style="margin-left:1em" ;> ITEMS YOU HAVE SELECTED</h1>

        <br>
        <br>
        <div>
            <?php
            if (!empty($cartItems)) {
                $noItems = count($cartItems);

                $key = 0;
                foreach ($itemsInfo as $itemId => $item) {

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
                        // Item Qty decrement.
                        $itemHtml .= "<a type=\"button\" href='addtocart.php?from=cart&item=".$item['id']."&qty=-1'>-</a>";
                        $itemHtml .= "<input type='number' value='".$cartItems[$item['id']]."' name ='qty_".$item['id'].
                            "' min='0' max='3' style='width: 15%;' disabled = 'disabled'/>";
                        // Item Qty increment.
                        $itemHtml .= "<a type=\"btn\" href='addtocart.php?from=cart&item=".$item['id']."&qty=1'>+</a>";
                    }

                    $itemHtml .= "</div>";
                    if ((($key + 1) % 4) === 0 || $noItems === ($key + 1)) {
                        $itemHtml .= "</div>";
                    }

                    echo $itemHtml;
                    ++$key;
                }
            }
            ?>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2" style="font-size: 20px;">
                <p>Here is Your Bill</p>
                <table class="table table-hover">
                    <thead>
                        <td>Item</td>
                        <td>Qty</td>
                        <td>Price</td>
                        <td>Total Price</td>
                    </thead>
                    <tbody>
                    <?php
                        $totalBill = 0;
                        foreach ($cartItems as $id => $cartItem) {
                            $itemTotalPrice = $itemsInfo[$id]['price'] * $cartItem;
                            $billEntry =
                                '<tr>'.
                                    '<td>'.$itemsInfo[$id]['name'].'</td>'.
                                    '<td>'.$cartItem.'</td>'.
                                    '<td>'.$itemsInfo[$id]['price'].'</td>'.
                                    '<td>'.$itemTotalPrice.'</td>'.
                                '</tr>'
                            ;
                            $totalBill += $itemTotalPrice;

                            echo $billEntry;
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <?php
                    $placeOrderLink = '';
                    if (count($cartItems) > 0) {
                        $placeOrderLink .= '<a class="btn btn-success" href="create_order.php">Place Order</a>';
                    }

                    echo $placeOrderLink;
                ?>
            </div>
        </div>
        <br>
        <div class="row">
            <h2>Your Total Bill Amount is: <?php echo $totalBill;?></h2>
        </div>
        <br><br>
    </div>
</body>
</html>