<?php
include("login.php"); 

if (empty($_SESSION['name'])) {
    header("location: signin.php");
    exit(); // Ensure the script stops after redirection
}

$emailid = $_SESSION['email'];
$connection = mysqli_connect("localhost", "root", "", 'demo');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $foodname = mysqli_real_escape_string($connection, $_POST['foodname']);
    $meal = mysqli_real_escape_string($connection, $_POST['meal']);
    $category = $_POST['image-choice'];
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
    $phoneno = mysqli_real_escape_string($connection, $_POST['phoneno']);
    $district = mysqli_real_escape_string($connection, $_POST['district']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $name = mysqli_real_escape_string($connection, $_POST['name']);

    // Server-side validation
    if (!preg_match("/^[A-Za-z\s]+$/", $foodname)) {
        echo '<script type="text/javascript">alert("Food name should contain only alphabetic characters.")</script>';
    } elseif (!preg_match("/^(97|98)[0-9]{8}$/", $phoneno)) {
        echo '<script type="text/javascript">alert("Phone number should start with 97 or 98 and be 10 digits long.")</script>';
    } elseif (!is_numeric($quantity) || $quantity < 1 || $quantity > 100) {
        echo '<script type="text/javascript">alert("Quantity should be a number between 1 and 100.")</script>';
    } else {
        $query = "INSERT INTO food_donations(email, food, type, category, phoneno, location, address, name, quantity) 
                  VALUES ('$emailid', '$foodname', '$meal', '$category', '$phoneno', '$district', '$address', '$name', '$quantity')";
        $query_run = mysqli_query($connection, $query);
        if ($query_run) {
            echo '<script type="text/javascript">alert("Data saved")</script>';
            header("location: delivery.html");
            exit();
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
    <title>Food Donate</title>
    <link rel="stylesheet" href="loginstyle.css">
    <style>
        .error {
            color: red;
            font-size: 12px;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const foodNameInput = document.getElementById("foodname");
            const phoneNumberInput = document.getElementById("phoneno");
            const quantityInput = document.getElementById("quantity");

            const foodNameError = document.getElementById("foodname-error");
            const phoneNumberError = document.getElementById("phoneno-error");
            const quantityError = document.getElementById("quantity-error");

            foodNameInput.addEventListener("input", function() {
                if (!/^[A-Za-z\s]+$/.test(foodNameInput.value)) {
                    foodNameError.textContent = "Food name should contain only alphabetic characters.";
                } else {
                    foodNameError.textContent = "";
                }
            });

            phoneNumberInput.addEventListener("input", function() {
                if (!/^(97|98)[0-9]{8}$/.test(phoneNumberInput.value)) {
                    phoneNumberError.textContent = "Phone number should start with 97 or 98 and be 10 digits long.";
                } else {
                    phoneNumberError.textContent = "";
                }
            });

            quantityInput.addEventListener("input", function() {
                const quantity = parseInt(quantityInput.value, 10);
                if (isNaN(quantity) || quantity < 1 || quantity > 100) {
                    quantityError.textContent = "Quantity should be a number between 1 and 100.";
                } else {
                    quantityError.textContent = "";
                }
            });

            document.querySelector("form").addEventListener("submit", function(event) {
                let isValid = true;

                if (!/^[A-Za-z\s]+$/.test(foodNameInput.value)) {
                    foodNameError.textContent = "Food name should contain only alphabetic characters.";
                    isValid = false;
                }

                if (!/^(97|98)[0-9]{8}$/.test(phoneNumberInput.value)) {
                    phoneNumberError.textContent = "Phone number should start with 97 or 98 and be 10 digits long.";
                    isValid = false;
                }

                const quantity = parseInt(quantityInput.value, 10);
                if (isNaN(quantity) || quantity < 1 || quantity > 100) {
                    quantityError.textContent = "Quantity should be a number between 1 and 100.";
                    isValid = false;
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });
        });
    </script>
</head>
<body style="background-color: #06C167;">
    <div class="container">
        <div class="regformf">
            <form action="" method="post">
                <p class="logo">Food <b style="color: #06C167;">Donate</b></p>
                <div class="input">
                    <label for="foodname">Food Name:</label>
                    <input type="text" id="foodname" name="foodname" required/>
                    <div class="error" id="foodname-error"></div>
                </div>
                <div class="radio">
                    <label for="meal">Meal type:</label> 
                    <br><br>
                    <input type="radio" name="meal" id="veg" value="veg" required/>
                    <label for="veg" style="padding-right: 40px;">Veg</label>
                    <input type="radio" name="meal" id="Non-veg" value="Non-veg">
                    <label for="Non-veg">Non-veg</label>
                </div>
                <br>
                <div class="input">
                    <label for="food">Select the Category:</label>
                    <br><br>
                    <div class="image-radio-group">
                        <input type="radio" id="raw-food" name="image-choice" value="raw-food">
                        <label for="raw-food">
                            <img src="img/raw-food.png" alt="raw-food">
                        </label>
                        <input type="radio" id="cooked-food" name="image-choice" value="cooked-food" checked>
                        <label for="cooked-food">
                            <img src="img/cooked-food.png" alt="cooked-food">
                        </label>
                        <input type="radio" id="packed-food" name="image-choice" value="packed-food">
                        <label for="packed-food">
                            <img src="img/packed-food.png" alt="packed-food">
                        </label>
                    </div>
                </div>
                <div class="input">
                    <label for="quantity">Quantity (number of person/kg):</label>
                    <input type="text" id="quantity" name="quantity" required/>
                    <div class="error" id="quantity-error"></div>
                </div>
                <b><p style="text-align: center;">Contact Details</p></b>
                <div class="input">
                    <div>
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo $_SESSION['name']; ?>" required/>
                    </div>
                    <div>
                        <label for="phoneno">Phone Number:</label>
                        <input type="text" id="phoneno" name="phoneno" maxlength="10" pattern="[0-9]{10}" required />
                        <div class="error" id="phoneno-error"></div>
                    </div>
                </div>
                <div class="input">
                    <label for="location">Location:</label>
                    <select id="district" name="district" style="padding:10px;">
                        <option value="Kathmandu">Kathmandu</option>
                        <option value="Bhaktapur">Bhaktapur</option>
                        <option value="Lalitpur">Lalitpur</option>
                        <option value="Nuwakot">Nuwakot</option>
                        <option value="Kavre">Kavre</option>
                    </select> 
                    <br>
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required/><br>
                </div>
                <div class="btn">
                    <button type="submit" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
