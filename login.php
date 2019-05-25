<?php

require_once(__DIR__.'/src/helpers/DbConnection.php');
require_once(__DIR__.'/src/repository/UserRepository.php');

session_start();

// Checking if user is already loggedin
$isLoggedIn = isset($_SESSION['username']) && is_string($_SESSION['username']);

if (true === $isLoggedIn) {
    header("Location: index.php");
}

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $obj = DbConnection::getNewConnectionObj();
    $usersRepo = new UserRepository($obj->getConnection());

    $user = $usersRepo->validateCredentials($_POST['username'], $_POST['password']);

    if (empty($user)) {
        header("Location: login.php");
    } else {
        $_SESSION['username'] = $user['username'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['address'] = $user['address'];
        header("Location: index.php");
    }
}

?>
<!DOCTYPE html>
<html>
<?php include "header.php"?>
<body>
    <?php include 'navbar.php'?>
    <p style="text-align:center;"> <font size='32'>Foodie Therapy</font></p>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="box1">
        <div class="form">
            <img src="images/loginimage.jpg" class="avatar" style='width:100px; height:100px; border-radius:50%; position:absolute; top:10px; left:calc(50%-50px)'>
            <p style="text-align:center;"> <font size='46'><font color='blue'><u>LOGIN</u></font></font></p><br><br>
            <font size='30'><form method="POST" action="login.php" align='center';>
                    Mobile Number:<br>
                    <input type="text" name="username" placeholder="Enter your Mobile Number" size='28' style='width: 250px; height: 30px;'>
                    <br>
                    Password:<br>
                    <input type="password" name="password" placeholder="Enter your Password" size='28' style='width: 250px; height: 30px;'><br>

                    <input type="submit" value="Submit" style='width: 100px; height: 50px; background-color: black; color: white;'><br>
            </font>
            <b> Don't have an account? <a href="signup.php">Sign up</a></b>
        </div>
    </div>
</body>
</html>