<?php
session_start();
include 'connection.php';

if(isset($_POST['sign'])){
  $user_email = $_POST['email'];
  $user_password = $_POST['password'];

  $select_query = "SELECT * FROM `login` WHERE email = '$user_email'";
  $result = mysqli_query($connection, $select_query);
  $row = mysqli_num_rows($result);
  $row_data = mysqli_fetch_array($result);

  if($row > 0){

      if($user_password === $row_data['password']){
          if($row_data['email_verified']){ 
            $_SESSION['email'] = $user_email;
            $_SESSION['name'] = $row_data['name'];
            $_SESSION['gender'] = $row_data['gender'];
            echo "<script>alert('Login successfully')</script>";
            echo "<script>window.open('home.html', '_self')</script>";
          } else {
              echo "<script>alert('Please verify your email before logging in')</script>";
              echo "<script>window.open('signin.php', '_self')</script>";
          }
      } else {
          echo "<script>alert('Invalid Credentials')</script>";
          echo "<script>window.open('signin.php', '_self')</script>";
      }
  } else {
      echo "<script>alert('Invalid Credentials')</script>";
      echo "<script>window.open('signin.php', '_self')</script>";

  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="loginstyle.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<body>
    <style>
        .uil {

            top: 42%;
        }
    </style>
    <div class="container">
        <div class="regform">
            <form action=" " method="post">
                <p class="logo" style="">Food <b style="color:#06C167; ">Donate</b></p>
                <p id="heading" style="padding-left: 1px;"> Welcome back ! <img src="" alt=""> </p>

                <div class="input">
                    <input type="email" placeholder="Email address" name="email" value="" required />
                </div>
                <div class="password">
                    <input type="password" placeholder="Password" name="password" id="password" required />
                    <i class="uil uil-eye-slash showHidePw"></i>
                </div>
                <div class="btn">
                    <button type="submit" name="sign"> Sign in</button>
                </div>
                <div class="signin-up">
                    <p id="signin-up">Don't have an account? <a href="signup.php">Register</a></p>
                </div>
            </form>
        </div>
    </div>
    <script src="login.js"></script>
    <script src="admin/login.js"></script>
</body>

</html>