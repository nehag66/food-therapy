<?php

session_start();

if (isset($_SESSION['username']) && is_string($_SESSION['username'])) {
    unset($_SESSION['username']);
    session_destroy();
}

header('Location: index.php');