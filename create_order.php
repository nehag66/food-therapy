<?php
require_once('src/helpers/DbConnection.php');
require_once('src/repository/ItemsRepository.php');
require_once('src/repository/OrderRepository.php');
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
$orderRepo = new OrderRepository($obj->getConnection());

$itemsInfo = $itemsRepo->getItemsDetail(array_keys($cartItems));

$orderId = $orderRepo->createNewOrder($itemsInfo, $cartItems, $_SESSION['id']);

if ($orderId) {
    unset($_SESSION['cart']);
}

?>
<!DOCTYPE html>
<html>
<?php include "header.php" ?>
<body>
    <?php include 'navbar.php' ?>
    <br>
    <br>
    <div class="container">
        <h2>
            <?php
                if (!$orderId) {
                    echo
                    "<div class=\"alert alert-danger\" role=\"alert\">
                        Some error occurred while processing your order, 
                        please contact customer care to check. 
                    </div>";
                } else {
                    echo
                    "<div class=\"alert alert-success\" role=\"alert\">
                        Well Done, your Order has been successfully Created with Order ID: $orderId
                    </div>";
                }
            ?>
        </h2>
    </div>
</body>
</html>
