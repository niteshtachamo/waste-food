<?php
session_start();
include '../connection.php';

$msg = 0;

if (isset($_POST['sign'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sanitized_emailid = mysqli_real_escape_string($connection, $email);
    $sanitized_password = mysqli_real_escape_string($connection, $password);

    $sql = "SELECT * FROM admin WHERE email='$sanitized_emailid'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($sanitized_password, $row['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['a_name'] = $row['name'];
                $_SESSION['location'] = $row['location'];
                $_SESSION['Aid'] = $row['Aid'];
                header("location:admin.php");
            } else {
                $msg = 1;
            }
        }
    } else {
        echo "<h1><center>Account does not exist</center></h1>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="formstyle.css">
    <script src="signin.js" defer></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <form action="" id="form" method="post">
            <span class="title">Login</span>
            <br>
            <br>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" required>
                <div class="error"></div>
            </div>
            <label class="textlabel" for="password">Password</label>
            <div class="password">
                <input type="password" name="password" id="password" required/>
                <i class="uil uil-eye-slash showHidePw" id="showpassword"></i>                
                <?php
                if ($msg == 1) {
                    echo ' <i class="bx bx-error-circle error-icon"></i>';
                    echo '<p class="error">Password doesn\'t match.</p>';
                }
                ?> 
            </div>
            <button type="submit" name="sign">Login</button>
            <div class="login-signup" style="display: none;">
                <span class="text">Don't have an account?
                    <a href="signup.php" class="text login-link">Register</a>
                </span>
            </div>
        </form>
    </div>
    <script src="login.js"></script>
</body>
</html>
