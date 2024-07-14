<?php
include 'connection.php';

require 'D:\xampp\htdocs\food-waste\PHPMailer-master\src\Exception.php';
require 'D:\xampp\htdocs\food-waste\PHPMailer-master\src\PHPMailer.php';
require 'D:\xampp\htdocs\food-waste\PHPMailer-master\src\SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to generate a random verification code
function generateVerificationCode() {
    return rand(100000, 999999); // Generates a 6-digit code
}

// Create a new instance of the PHPMailer class
$mail = new PHPMailer();

// Set up SMTP configuration
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'tachamonitesh@gmail.com';
$mail->Password = 'dycvuypksmzaydiy';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$errors = [];

if (isset($_POST['sign'])) {
    $user_name = $_POST['name'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
    $gender = $_POST['gender'];

    $existing_email_query = "SELECT * FROM `login` WHERE email = '$user_email'";
    $existing_email_result = mysqli_query($connection, $existing_email_query);
    if (mysqli_num_rows($existing_email_result) > 0) {
        // Email already exists, display error message
        echo "<script>alert('Email is already registered. Please use a different email address.')</script>";
    } else {
        // Generate verification code
        $verification_code = generateVerificationCode();

        // Construct and execute the SQL query
        $insert_query = "INSERT INTO `login`(`name`, `email`, `password`, `gender`, `verification_code`, `email_verified`) VALUES ('$user_name','$user_email','$user_password', '$gender', '$verification_code', 0)";
        $result = mysqli_query($connection, $insert_query);

        if ($result) {
            // Send verification email
            $mail->setFrom('tachamonitesh@gmail.com', 'Food management');
            $mail->addAddress($user_email, $user_name);
            $mail->Subject = 'Verify your email address for registration';
            $mail->isHTML(true);
            $mail->Body = "Please use the following verification code to verify your email address: <strong>$verification_code</strong><br>Enter the code on the following page: <a href='http://localhost/food-waste/verify_email_click.php?code=$verification_code'>Verify Email</a>";

            if (!$mail->send()) {
                // Display error message if email sending fails
                echo "<script>alert('Failed to send verification email.')</script>";
            } else {
                // Inform user that registration is successful and they need to verify their email
                echo "<script>alert('Registration successful. Please check your email to verify your account:')</script>";
                echo "<script>window.open('verify_email.php', '_self')</script>";
            }
        } else {
            echo "<script>alert('Failed to insert user.')</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="loginstyle.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<body>
    <div class="container">
        <div class="regform">
            <form id="registrationForm" action=" " method="post">
                <p class="logo">Food <b style="color: #06C167;">Donate</b></p>
                <p id="heading">Create your account</p>
                <div class="input form-group">
                    <label class="textlabel" for="name">User name</label><br>
                    <input type="text" id="name" name="name" required />
                    <span id="usernameError" class="error"></span>
                </div>
                <div class="input form-group">
                    <label class="textlabel" for="email">Email</label>
                    <input type="email" id="email" name="email" required />
                    <span id="emailError" class="error"></span>
                </div>
                <label class="textlabel" for="password">Password</label>
                <div class="password form-group">
                    <input type="password" name="password" id="password" required />
                    <i class="uil uil-eye-slash showHidePw" id="showpassword"></i>
                    <span id="passwordError" class="error"></span>
                </div>
                <div class="radio">
                    <input type="radio" name="gender" id="male" value="male" required />
                    <label for="male">Male</label>
                    <input type="radio" name="gender" id="female" value="female">
                    <label for="female">Female</label>
                </div>
                <div class="btn">
                    <button type="submit" name="sign">Continue</button>
                </div>
                <div class="signin-up">
                    <p style="font-size: 20px; text-align: center;">Already have an account? <a href="signin.php">Sign in</a></p>
                </div>
            </form>
        </div>
    </div>
    <script src="admin/login.js"></script>
</body>
</html>
