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
            <a href="mycart.php">MY CART</a>
            <a href="about_page.php">ABOUT US</a>
            <button class="signup"  onclick="location.href='login.php';">SignIn</button>
        </div>
    </div>
</div>
<br>
<br>
<h1 align="center"> REVIEW YOUR ORDER </h1> <br> <br>
<h1 style="margin-left:2em";> ITEMS YOU HAVE SELECTED</h1>

<img src="images/golgappe.jpg">
Qty <br>
!-- Quantity -->
<div class="quantity-number-v2 clearfix">
    <div class="quantity-wrapper">
        <i class="add-down add-action fa fa-minus"></i>
        <input id="prodQuantity" type="text" name="quantity" value="700" />
        <i class="add-up add-action fa fa-plus"></i>
    </div>
    <div id="stock" class="text-center"></div>
</div>
<!-- /Quantity -->

Price <br>
24

<br>
<button class="place_order">PLACE ORDER</button>

</body>
</html>