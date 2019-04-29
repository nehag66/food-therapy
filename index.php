<?php
// Starting session.
session_start();

// Checking if user is already loggedin
$isLoggedIn = isset($_SESSION['username']) && is_string($_SESSION['username']);

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body background="images/wallpaper_final.jpg">
<div>
    <div class= "menu">
        <div class= "leftmenu">
            <h2>Foodie Therapy</h2>
        </div>
        <div class="topnav">
            <a href="index.php">HOME</a>
            <a href="gallery.php">MENU</a>
            <?php
                if (true === $isLoggedIn) {
                    echo "<a href=\"mycart.php\">MY CART</a>";
                    echo
                        "<h3 style='color: white;float: right;'>Welcome ".$_SESSION['name']."</h3>
                        <a href='logout.php' class='signup' style='float: right;'>Logout</a>";
                } else {
                    echo
                    "<a href=\"about_page.php\">ABOUT US</a>
                    <button class=\"signup\"  onclick=\"location.href='login.php';\">Sign In</button>";
                }
            ?>
        </div>
    </div>
    <br>
    <div class="slider">
        <figure>
            <img src="images/samosa.jpg"/></a>
            <img src="images/tea.jpg"/></a>
            <img src="images/spring roll.jpg"/></a>
            <img src="images/rasmalai.jpg"/></a>
            <img src="images/tikki.jpg"/></a>
            <img src="images/noodles.jpg"/></a>
        </figure>
    </div>
    <br>
    <br>
    <div class= "text">
        <p style="text-align:center;"><font size='50'><b>WELCOME FOODIES!!!</font></p></b>
        <h3>One cannot think well, love well or sleep well, if one has not dined well...</h3>
        <h3>First we eat then we do anything else.</h3>
        <h3>Sharing food with our loved ones make the bond stronger...!!</h3>
        <div id="maindiv">
            <div id="div1">
                &nbsp;FOR MORE INFORMATION CONTACT 9871482594 &nbsp;&nbsp;&nbsp; FOR MORE INFORMATION CONTACT 9871482594 &nbsp;&nbsp;&nbsp; FOR MORE INFORMATION CONTACT 9871482594 &nbsp;&nbsp;&nbsp; FOR MORE INFORMATION CONTACT 9871482594
            </div>
        </div>
    </div>
</div>
</body>
</html>