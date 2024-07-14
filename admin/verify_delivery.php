<?php
include("connect.php"); 

// Start the output buffering
ob_start(); 

// Check if the admin is logged in
if($_SESSION['a_name'] == ''){
    header("location:signin.php");
    exit();
}

if (isset($_GET['action']) && isset($_GET['delivery_id'])) {
    $action = $_GET['action'];
    $delivery_id = intval($_GET['delivery_id']); // Ensure delivery_id is an integer for security

    if ($action === 'verify') {
        // Verify the delivery person
        $sql = "UPDATE delivery_persons SET verify = 1 WHERE Did = $delivery_id";
        if (mysqli_query($connection, $sql)) {
            echo "<script>alert('Delivery person verified successfully.')</script>";
        } else {
            echo "Error verifying delivery person: " . mysqli_error($connection);
        }
    } elseif ($action === 'delete') {
        // Delete the delivery person
        $sql = "DELETE FROM delivery_persons WHERE Did = $delivery_id";
        if (mysqli_query($connection, $sql)) {
            echo "<script>alert('Delivery person deleted successfully.')</script>";
        } else {
            echo "Error deleting delivery person: " . mysqli_error($connection);
        }
    }
    // Redirect back to the previous page (e.g., dashboard)
    // header("location:admin_dashboard.php");
    // exit();
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
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Admin Dashboard Panel</title> 
</head>
<body>
    <?php include('nav-bar.php');?>

    <section class="dashboard">
    <?php include('top-header.php');?>

        <br><br><br>
        <div class="delivery-table">
            <table>
                <thead>
                    <th>Delivery ID</th>
                    <th>Delivery Name</th>
                    <th>Delivery email</th>
                    <th>Delivery Address</th>
                    <th>Delivery Front Image</th>
                    <th>Delivery Back Image</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM delivery_persons";
                    $result = mysqli_query($connection, $sql);

                    if($result && mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            $verify_option = $row['verify'];
                            echo "<tr>";
                            echo "<td>".htmlspecialchars($row['Did'])."</td>";
                            echo "<td>".htmlspecialchars($row['name'])."</td>";
                            echo "<td>".htmlspecialchars($row['email'])."</td>";
                            echo "<td>".htmlspecialchars($row['city'])."</td>";
                            echo "<td><img height=' 100 ' width=' 100' src='../delivery/uploads/" . $row['front_image'] . "' alt='" . $row['name'] . "'></td>";
                            echo "<td><img height=' 100 ' width=' 100' src='../delivery/uploads/" . $row['back_image'] . "' alt='" . $row['name'] . "'></td>";
                            echo "<td>";
                            if($verify_option == 0){
                                echo "<a href='verify_delivery.php?action=verify&delivery_id=".urlencode($row['Did'])."'>
                                        <button class='btn btn-success'>Verify</button>
                                    </a>";
                            }
                            echo "<a href='verify_delivery.php?action=delete&delivery_id=".urlencode($row['Did'])."' onclick='return confirm(\"Are you sure you want to delete this account?\")'>
                                    <button class='btn btn-danger'>Delete</button>
                                </a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No delivery persons found.</td></tr>";
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </section>
    <script src="jquery.js"></script>
    <script src="admin.js"></script>
</body>
</html>
