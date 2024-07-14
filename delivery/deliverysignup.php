<?php
include '../connection.php';
$msg = 0;
if(isset($_POST['sign'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $location = $_POST['district'];

    $pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "SELECT * FROM delivery_persons WHERE email='$email'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);
    if($num == 1) {
        echo "<h1><center>Account already exists</center></h1>";
    } else {
        $target_dir = "uploads/";
        $front_image = $_FILES["image_front"]["name"];
        $back_image = $_FILES["image_back"]["name"];
        
        // Move uploaded files to target directory
        move_uploaded_file($_FILES["image_front"]["tmp_name"], $front_image);
        move_uploaded_file($_FILES["image_back"]["tmp_name"], $back_image);
        
        $query = "INSERT INTO delivery_persons(name, email, password, city, front_image	, back_image) VALUES('$username', '$email', '$pass', '$location', '$front_image', '$back_image')";
        $query_run = mysqli_query($connection, $query);
        if($query_run) {
            header("Location: delivery.php");
        } else {
            echo '<script type="text/javascript">alert("Data not saved")</script>';
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

    <title>Animated Login Form | CodingNepal</title>
    <link rel="stylesheet" href="deliverycss.css">
</head>

<body>
    <div class="center">
        <h1>Register</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="txt_field">
                <input type="email" name="email" required />
                <span></span>
                <label>Email</label>
            </div>
            <div class="txt_field">
                <input type="text" name="username" required />
                <span></span>
                <label>Username</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" required />
                <span></span>
                <label>Password</label>
            </div>

            <div class="txt_field image border-none">
                <label>Citizenship Front Image</label>
                <input type="file" name="image_front" required />
                <!-- <span></span> -->
            </div>
            <div class="txt_field image ">
                <label>Citizenship Back Image</label>
                <input type="file" name="image_back" required />
                <!-- <span></span> -->
            </div>
            <div class="">
                <!-- <label for="district">District:</label> -->
                <select id="district" name="district" style="padding:10px; padding-left: 20px;">
                    <option value="Kathmandu">Kathmandu</option>
                    <option value="Bhaktapur">Bhaktapur</option>
                    <option value="Lalitpur">Lalitpur</option>
                    <option value="Nuwakot">Nuwakot</option>
                    <option value="Kavre">Kavre</option>
                </select>

            </div>
            <br>

            <input type="submit" name="sign" value="Register">
            <div class="signup_link">
                Alredy a member? <a href="deliverylogin.php">Sigin</a>
            </div>
        </form>
    </div>

</body>

</html>