<?php
require_once('src/helpers/DbConnection.php');
require_once('src/repository/ItemsRepository.php');

$obj = DbConnection::getNewConnectionObj();
$itemsRepo = new ItemsRepository($obj->getConnection());

$foodItems = $itemsRepo->getPaginationItems('FOOD', 1, 100);
?>

<html>
<head>
    <title></title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/gallery.css">

</head>
<body background="images/wallpaper_final.jpg">
<div>
    <div class= "menu">
        <div class= "leftmenu" >
            <h2>Foodie Therapy</h2>
        </div>
        <div class="topnav2">
            <a href="index.php">HOME</a>
            <a href="gallery.php">MENU</a>
            <a href="mycart.php">MY CART</a>
            <a href="about_page.php">ABOUT US</a>
            <button class="signup"  onclick="location.href='login.php';">SignIn</button>
        </div>
    </div>

    <div class="text">
        <h4><u>FOOD CORNER</u></h4>
        <?php
        if (!empty($foodItems) && !empty($foodItems['FOOD'])) {
            foreach ($foodItems['FOOD'] as $key => $item) {
                if (($key + 1) % 4 === 1) {
                    echo '<div class="row">';
                }
                echo "<div class=\"column\">
                        <img src=\"".$item["image_url"]."\">
                        <div>
                            <b align = 'right'>".$item['name']."</b>
                        </div>
                        <div>
                            <b align = 'right'>".$item['price']."</b>
                        </div>
                        <div>
                            <input type='number' value='0' name ='qty_".$item['id']."' min='0' max='3' style='width: 13%;'/>
                            <button type=\"button\">Add to cart</button>
                        </div>
                    </div>";
                if (($key + 1) % 4 === 1) {
                    echo "</div>";
                }
            }
        }
        ?>
    </div>
    <div>
        <hr>
        <br>
    </div>
</body>
</html>