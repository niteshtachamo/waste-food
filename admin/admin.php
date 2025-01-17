<?php
ob_start(); 
include("connect.php"); 

if($_SESSION['a_name'] == ''){
    header("location:signin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Admin Dashboard Panel</title> 
</head>
<body>
    <?php include('nav-bar.php');?>

    <section class="dashboard">
        <?php include('top-header.php');?>
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Dashboard</span>
                </div>
                <div class="boxes">
                    <div class="box box1">
                        <i class="uil uil-user"></i>
                        <span class="text">Total users</span>
                        <?php
                        $query = "SELECT count(*) as count FROM login";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo "<span class=\"number\">".$row['count']."</span>";
                        ?>
                    </div>
                    <div class="box box2">
                        <i class="uil uil-comments"></i>
                        <span class="text">Feedbacks</span>
                        <?php
                        $query = "SELECT count(*) as count FROM user_feedback";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo "<span class=\"number\">".$row['count']."</span>";
                        ?>
                    </div>
                    <div class="box box3">
                        <i class="uil uil-heart"></i>
                        <span class="text">Total donates</span>
                        <?php
                        $query = "SELECT count(*) as count FROM food_donations";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo "<span class=\"number\">".$row['count']."</span>";
                        ?>
                    </div>
                </div>
            </div>
            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">Recent Donations</span>
                </div>
                <div class="get">
                    <?php
                    $loc = $_SESSION['location'];
                    $sql = "SELECT * FROM food_donations WHERE assigned_to IS NULL and location='$loc'";
                    $result = mysqli_query($connection, $sql);
                    $id = $_SESSION['Aid'];

                    if (!$result) {
                        die("Error executing query: " . mysqli_error($connection));
                    }

                    $data = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $data[] = $row;
                    }

                    if (isset($_POST['food']) && isset($_POST['delivery_person_id'])) {
                        $order_id = $_POST['order_id'];
                        $delivery_person_id = $_POST['delivery_person_id'];
                        $sql = "SELECT * FROM food_donations WHERE Fid = $order_id AND assigned_to IS NOT NULL";
                        $result = mysqli_query($connection, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            die("Sorry, this order has already been assigned to someone else.");
                        }

                        $sql = "UPDATE food_donations SET assigned_to = $delivery_person_id WHERE Fid = $order_id";
                        $result = mysqli_query($connection, $sql);

                        if (!$result) {
                            die("Error assigning order: " . mysqli_error($connection));
                        }

                        header('Location: ' . $_SERVER['REQUEST_URI']);
                        ob_end_flush();
                    }
                    ?>
                    <div class="table-container">
                        <div class="table-wrapper">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Food</th>
                                        <th>Category</th>
                                        <th>Phone No</th>
                                        <th>Date/Time</th>
                                        <th>Address</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $row) { ?>
                                    <tr>
                                        <td data-label="Name"><?= $row['name'] ?></td>
                                        <td data-label="Food"><?= $row['food'] ?></td>
                                        <td data-label="Category"><?= $row['category'] ?></td>
                                        <td data-label="Phone No"><?= $row['phoneno'] ?></td>
                                        <td data-label="Date/Time"><?= $row['date'] ?></td>
                                        <td data-label="Address"><?= $row['address'] ?></td>
                                        <td data-label="Quantity"><?= $row['quantity'] ?></td>
                                        <td data-label="Action" style="margin:auto">
                                            <?php if ($row['assigned_to'] == null) { ?>
                                            <form method="post" action="">
                                                <input type="hidden" name="order_id" value="<?= $row['Fid'] ?>">
                                                <input type="hidden" name="delivery_person_id" value="<?= $id ?>">
                                                <button type="submit" name="food">Get Food</button>
                                            </form>
                                            <?php } else if ($row['assigned_to'] == $id) { ?>
                                            Order assigned to you
                                            <?php } else { ?>
                                            Order assigned to another delivery person
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="jquery.js"></script>
    <script src="admin.js"></script>
</body>
</html>
