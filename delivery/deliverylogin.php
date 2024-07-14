<?php
session_start();
include '../connection.php'; 

$msg = 0;

if (isset($_POST['sign'])) {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $sql = "SELECT * FROM delivery_persons WHERE email='$email'";
    $result = mysqli_query($connection, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if ($row['verify'] == 1) { // Check if the account is verified
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row['name'];
                $_SESSION['Did'] = $row['Did'];
                $_SESSION['city'] = $row['city'];
                header("Location: delivery.php");
                exit;
            } else {
                $msg = 1;  // Incorrect password
            }
        } else {
            $msg = 2; // Account not verified
        }
    } else {
        $msg = 3; // Account does not exist
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="deliverycss.css">
</head>
<body>
    <div class="center">
        <h1>Delivery Login</h1>
        <form method="post">
            <div class="txt_field">
                <input type="email" name="email" required />
                <span></span>
                <label>Email</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" required />
                <span></span>
                <label>Password</label>
            </div>
            <?php
                if ($msg == 1) {
                    echo "<p style='color:red;'>Incorrect password. Please try again.</p>";
                } elseif ($msg == 2) {
                    echo "<p style='color:red;'>Your account is not verified by the admin. Please contact support.</p>";
                } elseif ($msg == 3) {
                    echo "<p style='color:red;'><center>Account does not exist</center></p>";
                }
            ?>
            <br>
            <input type="submit" value="Login" name="sign">
            <div class="signup_link">
                Not a member? <a href="deliverysignup.php">Signup</a>
            </div>
        </form>
    </div>
</body>
</html>
