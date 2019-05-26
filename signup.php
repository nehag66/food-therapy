<?php
require_once(__DIR__ . '/src/helpers/DbConnection.php');
require_once(__DIR__ . '/src/repository/UserRepository.php');

session_start();

// Checking if user is already loggedin
$isLoggedIn = isset($_SESSION['username']) && is_string($_SESSION['username']);

if (true === $isLoggedIn) {
    header("Location: index.php");
}

$errorMsg = [];
$createFail = false;

if (
        !empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['c_password'])
    &&  !empty($_POST['mobile']) && !empty($_POST['address'])
) {
    if (strlen($_POST['name']) > 50) {
        $errorMsg[] = 'Name is too Long, max 50 chars are allowed';
    }

    if (strlen($_POST['mobile']) !== 10) {
        $errorMsg[] = 'Mobile No is invalid, it should be length 10';
    }

    if (strlen($_POST['address']) > 200) {
        $errorMsg[] = 'Address is too Long, max 200 chars are allowed';
    }

    if (strlen($_POST['password']) > 50) {
        $errorMsg[] = 'Password is too Long, max 50 chars are allowed';
    }

    if ($_POST['c_password'] !== $_POST['password']) {
        $errorMsg[] = 'Password and Confirm password do not match.';
    }

    if (count($errorMsg) === 0) {
        $obj = DbConnection::getNewConnectionObj();
        $usersRepo = new UserRepository($obj->getConnection());

        $createResult = $usersRepo->signUp(
                $_POST['name'],
                $_POST['password'],
                $_POST['address'],
                $_POST['mobile']
        );

        if (!$createResult) {
            $createFail = true;
        }
    }
}


?>
<!DOCTYPE html>
<html>
<?php include "header.php" ?>
<body>
<?php include 'navbar.php' ?>
<div class="container">
    <br>
    <p style="text-align:center;"><font size='32'>Foodie Therapy</font></p>
    <br>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $result = '<ul class="list-group">';
                    if (false === $createFail && count($errorMsg) > 0) {
                        foreach ($errorMsg as $msg) {
                            $result .= '<li class="list-group-item list-group-item-danger">'.$msg.'</li>';

                        }
                    } else {
                        $result .=
                            '<li class="list-group-item list-group-item-success">Your are registered Successfully.'.
                                'You can proceed with <a href="login.php">Login Now</a>.'
                            .'</li>';
                    }

                    $result .= '</ul>';
                    echo $result;
                }
            ?>
        </div>
    </div>
    <br>
    <div class="box2">
        <img src="images/loginimage.jpg" class="avatar"
             style='width:100px; height:100px; border-radius:50%; position:absolute; top:10px; left:calc(50%-50px)'>

        <p style="text-align:center;"><font size='46'><font color='blue'><u>SIGN UP</u></font></font></p><br><br>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form align='center' method="post" action="signup.php">
                    <label style="font-size: 30px;"><strong>Your Name:</strong></label><br>
                    <input class="form-control" type="text" name="name" placeholder="Enter Name" size='28'
                           style='width: 250px; height: 30px;'><br>
                    <label style="font-size: 30px;"><strong>Mobile Number:</strong></label><br>
                    <input class="form-control" type="text" name="mobile" placeholder="Enter Mobile Number" size='28'
                           style='width: 250px; height: 30px;'><br>
                    <label style="font-size: 30px;"><strong>Address:</strong></label><br>
                    <input class="form-control" type="text" name="address" placeholder="Enter your address" size='28'
                              style='width: 250px; height: 30px;'/><br>
                    <label style="font-size: 30px;"><strong>Password:</strong></label><br>
                    <input class="form-control" type="password" name="password" placeholder="Enter Password" size='28'
                           style='width: 250px; height: 30px;'><br>
                    <label style="font-size: 30px;"><strong>Confirm Password:</strong></label><br>
                    <input class="form-control" type="password" name="c_password" placeholder="Confirm Password" size='28'
                           style='width: 250px; height: 30px;'><br>
                    <input class="form-control" type="submit" value="Submit"
                           style='width: 100px; height: 40px; background-color: black; color: white;'>
                    <br>
                </form>
                <b> Already a user? <a href="login.php">Login</a></b>
            </div>

        </div>

    </div>
    <br>
    <br>
    <br>
    <br>
</div>
</body>
</html>