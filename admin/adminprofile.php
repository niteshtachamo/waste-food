<?php
@session_start();
include("connect.php");

if (!isset($_SESSION['a_name']) || $_SESSION['a_name'] == '') {
    header("location:signin.php");
    exit();
}

if (isset($_GET['remove_food'])) {
    $product_id_to_remove = intval($_GET['remove_food']);
    if (isset($_GET['confirm_delete'])) {
        $sql = "DELETE FROM food_donations WHERE Fid = ?";
        if ($stmt = mysqli_prepare($connection, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $product_id_to_remove);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Product with ID $product_id_to_remove removed successfully')</script>";
                header("Location: {$_SERVER['PHP_SELF']}");
                exit();
            } else {
                echo "<script>alert('Failed to delete product.')</script>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('Failed to prepare the SQL statement.')</script>";
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
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <?php include('nav-bar.php');?>
    <section class="dashboard">
    <?php include('top-header.php');?>

        <br><br><br>
        <div class="activity">
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
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Define the SQL query to fetch assigned orders
                        $id = intval($_SESSION['Aid']);
                        $sql = "SELECT * FROM food_donations WHERE assigned_to = ?";
                        
                        if ($stmt = mysqli_prepare($connection, $sql)) {
                            mysqli_stmt_bind_param($stmt, "i", $id);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                            <td data-label='Name'>" . htmlspecialchars($row['name']) . "</td>
                                            <td data-label='Food'>" . htmlspecialchars($row['food']) . "</td>
                                            <td data-label='Category'>" . htmlspecialchars($row['category']) . "</td>
                                            <td data-label='Phone No'>" . htmlspecialchars($row['phoneno']) . "</td>
                                            <td data-label='Date/Time'>" . htmlspecialchars($row['date']) . "</td>
                                            <td data-label='Address'>" . htmlspecialchars($row['address']) . "</td>
                                            <td data-label='Quantity'>" . htmlspecialchars($row['quantity']) . "</td>
                                            <td class='action'>
                                                <a class='btn btn-danger' href='{$_SERVER['PHP_SELF']}?remove_food=" . htmlspecialchars($row['Fid']) . "&confirm_delete' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Remove</a>
                                                <a class='btn btn-success' href='edit_food.php?edit_food=" . htmlspecialchars($row['Fid']) . "'>Edit</a>
                                            </td>
                                          </tr>";
                                }
                                
                            } else {
                                echo "<tr><td colspan='8'>No records found.</td></tr>";
                            }
                            mysqli_stmt_close($stmt);
                        } else {
                            echo "<tr><td colspan='8'>Failed to prepare the SQL statement.</td></tr>";
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
