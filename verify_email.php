

<?php
include 'connection.php';

if (isset($_POST['verify'])) {
    $user_email = $_POST['email'];
    $entered_code = $_POST['verification_code'];

    // Verify the code against the database
    $query = "SELECT * FROM `login` WHERE email = '$user_email' AND verification_code = '$entered_code'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 1) {
        // Update user's email verification status
        $update_query = "UPDATE `login` SET email_verified = 1 WHERE email = '$user_email'";
        mysqli_query($connection, $update_query);
        echo "<script>alert('Your email has been successfully verified.');</script>";
        echo "<script>window.open('signin.php', '_self')</script>";
    } else {
        echo "<script>alert('Invalid verification code. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="loginstyle.css">
    <style>
        .btn-box{
            background-color: black;
            font-size: 20px;
            color: white;
            margin-top: 20px;
            padding: 14px 16px;
            border-radius: 8px;
            border: .5px solid black;
            width: calc(100% - 32px);
            display: block;
            text-align: center;
            text-decoration: none;
        }
        .btn-box:hover{
            color: #eeeeee;
            transform: scale(.98);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="regform">
            <form action="verify_email.php" method="post">
                <p class="logo">Food <b style="color: #06C167;">Donate</b></p>
                <p id="heading">Verify your email</p>
                <div class="input form-group">
                    <label class="textlabel" for="email">Email</label>
                    <input type="email" id="email" name="email" required />
                </div>
                <div class="input form-group">
                    <label class="textlabel" for="verification_code">Verification Code</label>
                    <input type="text" id="verification_code" name="verification_code" autocomplete="off" required />
                </div>
                <div class="btn">
                    <button type="submit" name="verify">Verify</button>
                    <br>
                    <a href="signin.php" class=" btn-box">Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

