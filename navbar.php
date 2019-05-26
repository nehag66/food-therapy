<?php

// Checking if user is already loggedin
$isLoggedIn = isset($_SESSION['username']) && is_string($_SESSION['username']);

?>

<div class= "menu">
    <div class= "leftmenu" >
        <h2>Foodie Therapy</h2>
    </div>
    <div class="topnav2">
        <a href="index.php">HOME</a>
        <a href="gallery.php">MENU</a>
        <?php
        if (true === $isLoggedIn) {
            echo "<a href=\"mycart.php\">MY CART</a>";
            echo "<a style='color: white;'>WELCOME ".strtoupper($_SESSION['name'])."</a>";
            echo "<button onclick=\"location.href= 'logout.php'\" class='signup'>Logout</button>";
        } else {
            echo
            "<a href=\"about_page.php\">ABOUT US</a>
            <button class=\"signup\"  onclick=\"location.href='login.php';\">Sign In</button>";
        }
        ?>
    </div>
</div>
