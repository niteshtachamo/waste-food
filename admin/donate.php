<?php
include "../connection.php";
include("connect.php"); 

if ($_SESSION['name'] == '') {
    header("location:signin.php");
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


        <div class="activity">
            <div class="location">
                <form method="post">
                    <label for="location" class="logo">Select Location:</label>
                    <select id="location" name="location">
                        <option value="Kathmandu">Kathmandu</option>
                        <option value="Bhaktapur">Bhaktapur</option>
                        <option value="Lalitpur">Lalitpur</option>
                        <option value="Nuwakot">Nuwakot</option>
                        <option value="Kavre">Kavre</option>
                    </select>
                    <input type="submit" value="Get Details">
                </form>
                <br>
                <?php
                if (isset($_POST['location'])) {
                    $location = $_POST['location'];
                    $sql = "SELECT * FROM food_donations WHERE location='$location'";
                    $result = mysqli_query($connection, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        echo "<div class=\"table-container\">";
                        echo "<div class=\"table-wrapper\">";
                        echo "<table class=\"table\">";
                        echo "<thead>";
                        echo "<tr>
                                <th>Name</th>
                                <th>Food</th>
                                <th>Category</th>
                                <th>Phone No</th>
                                <th>Date/Time</th>
                                <th>Address</th>
                                <th>Quantity</th>
                              </tr>";
                        echo "</thead><tbody>";

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td data-label=\"name\">{$row['name']}</td>
                                    <td data-label=\"food\">{$row['food']}</td>
                                    <td data-label=\"category\">{$row['category']}</td>
                                    <td data-label=\"phoneno\">{$row['phoneno']}</td>
                                    <td data-label=\"date\">{$row['date']}</td>
                                    <td data-label=\"Address\">{$row['address']}</td>
                                    <td data-label=\"quantity\">{$row['quantity']}</td>
                                  </tr>";
                        }
                        echo "</tbody></table></div>";
                    } else {
                        echo "<p>No results found.</p>";
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <script src="jquery.js"></script>

    <script src="admin.js"></script>
</body>
</html>
