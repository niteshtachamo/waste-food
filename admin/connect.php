<?php
@session_start();
include '../connection.php';
$msg = 0;

if (isset($_POST['sign'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sanitized_emailid =  mysqli_real_escape_string($connection, $email);
    $sanitized_password =  mysqli_real_escape_string($connection, $password);

    $sql = "select * from admin where email='$sanitized_emailid'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);
 
    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($sanitized_password, $row['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row['name'];
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
