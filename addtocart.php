<?php

session_start();
// Checking if user is already loggedin
$isLoggedIn = isset($_SESSION['username']) && is_string($_SESSION['username']);

if (false === $isLoggedIn) {
    header('Location: index.php');
    return;
}

$redirectLocation = (isset($_GET['from']) && $_GET['from'] === 'cart') ? 'mycart.php' : 'gallery.php';

if (!isset($_GET['item']) || !isset($_GET['qty'])) {
    header("Location: $redirectLocation");
}

$item = intval($_GET['item']);
$qty = intval($_GET['qty']);

$qtyToAdd =  $qty < -1 || $qty > 3 ? 1 : $qty;

$currentQty = empty($_SESSION['cart'][$item]) ? 0 : $_SESSION['cart'][$item];

if ((3 === $currentQty && $qtyToAdd > 0) || (0 === $currentQty && $qtyToAdd === -1)) {
    header("Location: $redirectLocation");
} else {
    $_SESSION['cart'][$item] = $currentQty + $qtyToAdd;

    if (0 === $_SESSION['cart'][$item]) {
        unset($_SESSION['cart'][$item]);
    }

    header("Location: $redirectLocation");
}