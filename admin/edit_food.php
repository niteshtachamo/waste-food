<?php 
// @session_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include 'connect.php';

if(isset($_GET['edit_food'])){
    $food_id = intval($_GET['edit_food']); // Ensure the ID is an integer for security

    $sql = "SELECT * FROM food_donations WHERE Fid = $food_id";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    
    $food_id = $row['Fid'];
    $food_name = $row['food'];
    $assigned_to = $row['assigned_to'];
    $delivery_by = $row['delivery_by'];
    $quantity = $row['quantity'];
    $location = $row['location'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $food_id = intval($_POST['food_id']);
    $food_name = $_POST['food_name'];
    $quantity = intval($_POST['quantity']);
    $location = $_POST['location'];
    $assigned_to = intval($_POST['assigned_to']);
    $delivery_by = intval($_POST['delivery_by']);

    $update_sql = "UPDATE food_donations SET food = '$food_name', quantity = $quantity, location = '$location', assigned_to = $assigned_to, delivery_by = $delivery_by WHERE Fid = $food_id";
    
    if (mysqli_query($connection, $update_sql)) {
        echo "<script>alert('Food details updated successfully');</script>";
        echo "<script>window.open('admin.php', '_self');</script>";
    } else {
        echo "<script>alert('Error updating record: " . mysqli_error($connection) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Food</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <section class="edit-food-detail py-5">
        <div class="container">
            <div class="main-title text-center">
                <h2 class="title">Edit Food</h2>
            </div>
            <div class="w-50 m-auto py-5">
                <form action="" method="post">
                    <input type="hidden" name="food_id" value="<?php echo $food_id; ?>">
                    <div class="form-group">
                        <label for="food_name">Food Name</label>
                        <input type="text" id="food_name" name="food_name" value="<?php echo htmlspecialchars($food_name); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <select name="location" id="location" class="form-control" required>
                            <option value="" disabled>Select Location</option>
                            <option value="bhaktapur" <?php if ($location == 'bhaktapur') echo 'selected'; ?>>Bhaktapur</option>
                            <option value="kathmandu" <?php if ($location == 'kathmandu') echo 'selected'; ?>>Kathmandu</option>
                            <option value="lalitpur" <?php if ($location == 'kathmandu') echo 'selected'; ?>>Lalitpur</option>
                            <option value="nuwakot" <?php if ($location == 'nuwakot') echo 'selected'; ?>>Nuwakot</option>
                            <option value="kavre" <?php if ($location == 'kavre') echo 'selected'; ?>>Kavre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="assigned_to">Assigned By</label>
                        <select name="assigned_to" id="assigned_to" class="form-control" required>
                            <option value="0" disabled>Select</option>
                            <?php 
                                $sql = "SELECT * FROM admin";
                                $res = mysqli_query($connection, $sql);
                                while ($admin_row = mysqli_fetch_assoc($res)) {
                                    echo "<option value='" . $admin_row['Aid'] . "'";
                                    if ($admin_row['Aid'] == $assigned_to) echo " selected";
                                    echo ">" . htmlspecialchars($admin_row['name']) . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="delivery_by">Delivery By</label>
                        <select name="delivery_by" id="delivery_by" class="form-control" required>
                            <option value="0">Select</option>
                            <?php 
                                $sql = "SELECT * FROM delivery_persons";
                                $res = mysqli_query($connection, $sql);
                                while ($delivery_row = mysqli_fetch_assoc($res)) {
                                    echo "<option value='" . $delivery_row['Did'] . "'";
                                    if ($delivery_row['Did'] == $delivery_by) echo " selected";
                                    echo ">" . htmlspecialchars($delivery_row['name']) . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
