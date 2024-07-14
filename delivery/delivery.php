<?php
@ob_start();
include("connect.php");
include '../connection.php';

if (empty($_SESSION['name']) && empty($_SESSION['city'])) {
    header("Location: deliverylogin.php");
    exit();
}

$name = $_SESSION['name'];
$city = $_SESSION['city'];

$id = $_SESSION['Did'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="delivery.css">
</head>
<body>
<header>
    <div class="logo">Food <b style="color: #06C167;">Donate</b></div>
    <div class="hamburger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
    <nav class="nav-bar">
        <ul>
            <li><a href="#home" class="active">Home</a></li>
            <li><a href="openmap.php">map</a></li>
            <li><a href="deliverymyord.php">myorders</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
<br>
<script>
    document.querySelector(".hamburger").onclick = function() {
        document.querySelector(".nav-bar").classList.toggle("active");
    }
</script>

<h2><center>Welcome <?php echo "$name"; ?></center></h2>
<div class="itm">
    <img src="../img/delivery.gif" alt="" width="400" height="400">
</div>

<?php
$sql = "SELECT fd.Fid AS Fid, fd.location as cure, fd.name, fd.phoneno, fd.date, fd.delivery_by, fd.address as From_address, ad.name AS delivery_person_name, ad.address AS To_address
FROM food_donations fd
LEFT JOIN admin ad ON fd.assigned_to = ad.Aid
WHERE assigned_to IS NOT NULL AND delivery_by IS NULL AND fd.location='$city'";

$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Error executing query: " . mysqli_error($connection));
}

// Debug: Check the number of rows returned
$num_rows = mysqli_num_rows($result);
echo "<script>console.log('Number of rows returned: $num_rows');</script>";

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Debug: Check the content of the $data array
echo "<script>console.log('Data: " . json_encode($data) . "');</script>";

if (isset($_POST['food']) && isset($_POST['delivery_person_id'])) {
    $order_id = $_POST['order_id'];
    $delivery_person_id = $_POST['delivery_person_id'];
    $sql = "SELECT * FROM food_donations WHERE Fid = $order_id AND delivery_by IS NOT NULL";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        die("Sorry, this order has already been assigned to someone else.");
    }

    $sql = "UPDATE food_donations SET delivery_by = $delivery_person_id WHERE Fid = $order_id";
    $result = mysqli_query($connection, $sql);

    if (!$result) {
        die("Error assigning order: " . mysqli_error($connection));
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
    ob_end_flush();
}
?>


</body>
</html>
