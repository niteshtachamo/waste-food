<?php
session_start();
include '../connection.php';

if (empty($_SESSION['name']) || empty($_SESSION['Did'])) {
    header("Location: deliverylogin.php");
    exit;
}

$name = $_SESSION['name'];
$id = $_SESSION['Did'];

// Fetch orders assigned to the logged-in delivery person
$sql = "SELECT fd.Fid AS Fid, fd.name, fd.phoneno, fd.date, fd.delivery_by, fd.address AS From_address, 
               ad.name AS delivery_person_name, ad.address AS To_address
        FROM food_donations fd
        LEFT JOIN admin ad ON fd.assigned_to = ad.Aid
        WHERE delivery_by='$id'";
$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Error executing query: " . mysqli_error($connection));
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="delivery.css">
    <link rel="stylesheet" href="../home.css">
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
                <li><a href="delivery.php">Home</a></li>
                <li><a href="openmap.php">Map</a></li>
                <li><a href="deliverymyord.php" class="active">My Orders</a></li>
                <li ><a href="../logout.php"  >Logout</a></li>
            </ul>
        </nav>
    </header>
    <br>
    <script>
        document.querySelector(".hamburger").onclick = function() {
            document.querySelector(".nav-bar").classList.toggle("active");
        };
    </script>
    <style>
        .itm {
            background-color: white;
            display: grid;
        }
        .itm img {
            width: 400px;
            height: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        p {
            text-align: center;
            font-size: 28px;
            color: black;
        }
        @media (max-width: 767px) {
            .itm img {
                width: 350px;
                height: 350px;
            }
        }
    </style>

    <div class="itm">
        <img src="../img/delivery.gif" alt="Delivery" width="400" height="400">
    </div>

    <div class="get">
        <!-- <a href="delivery.php">Take Orders</a> -->
        <p>Orders assigned to you</p>
        <br>
    </div>

    <div class="table-container">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone No</th>
                        <th>Date/Time</th>
                        <th>Pickup Address</th>
                        <th>Delivery Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['phoneno']) ?></td>
                            <td><?= htmlspecialchars($row['date']) ?></td>
                            <td><?= htmlspecialchars($row['From_address']) ?></td>
                            <td><?= htmlspecialchars($row['To_address']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <br><br>
</body>
</html>
