<?php

session_start();
// Checking if user is already loggedin
$isLoggedIn = isset($_SESSION['username']) && is_string($_SESSION['username']);

if (false === $isLoggedIn) {
    header('Location: index.php');
    return;
}

if (!isset($_GET['item']) || !isset($_GET['qty'])) {
    header('Location: gallery.php');
}

$item = intval($_GET['item']);
$qty = intval($_GET['qty']);

$qtyToAdd =  $qty < -1 || $qty > 3 ? 1 : $qty;

$currentQty = empty($_SESSION['cart'][$item]) ? 0 : $_SESSION['cart'][$item];

if ((3 === $currentQty && $qtyToAdd > 0) || (0 === $currentQty && $qtyToAdd === -1)) {
    header('Location: gallery.php');
} else {
    $_SESSION['cart'][$item] = $currentQty + $qtyToAdd;

    if (0 === $_SESSION['cart'][$item]) {
        unset($_SESSION['cart'][$item]);
    }

    header('Location: gallery.php');
}