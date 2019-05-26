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
        $_SESSION['id'] = $user['id'];
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
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <form method="POST" action="login.php" align='center';>
                            <label style="font-size: 30px;"><strong>Mobile Number:</strong></label>
                            <input type="text" class="form-control" name="username" placeholder="Enter your Mobile Number" size='28'>
                            <br><br>
                            <label style="font-size: 30px;"><strong>Password:</strong></label>
                            <input type="password" class="form-control" name="password" placeholder="Enter your Password" size='28'><br>

                            <input type="submit" value="Submit" style='width: 100px; height: 50px; background-color: black; color: white;'><br>
                        </form>
                        <b> Don't have an account? <a href="signup.php">Sign up</a></b>
                    </div>
                </div>
        </div>
    </div>
</body>
</html>