<?php
include '../connection.php';
include "connect.php";

if ($_SESSION['name'] == '') {
    header("location:signin.php");
    exit; // Added exit to stop further execution
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- CSS -->
    <link rel="stylesheet" href="admin.css">

    <!-- Iconscout CSS -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Admin Dashboard Panel</title>
</head>

<body>
    <?php include('nav-bar.php');?>
    <section class="dashboard">
    <?php include('top-header.php');?>

        <br>
        <br>
        <br>
        <div class="activity">
            <div class="table-container">
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>name</th>
                                <th>email</th>
                                <th>message</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "select * from user_feedback ";
                            $result = mysqli_query($connection, $query);
                            if ($result == true) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr><td data-label=\"name\">" . $row['name'] . "</td><td data-label=\"email\">" . $row['email'] . "</td><td data-label=\"message\">" . $row['message'] . "</td></tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script src="jquery.js"></script>

    <script src="admin.js"></script>
</body>
</html>
