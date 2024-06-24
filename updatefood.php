<?php
session_start();
require 'connection.php';

$page_title = 'Update Page';
include ('header.html');

// Check if the user is logged in, if not then redirect him to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Get the id of the record to update
$id = mysqli_real_escape_string($connection, $_GET['id']);

// Execute the query to select the record to update
$query = "SELECT * FROM calc_table WHERE id = '$id'";
$result = mysqli_query($connection, $query);

// Check if query is successful
if (!$result) {
    die('Query failed ' . mysqli_error($connection));
}

// Fetch the record to update
$row = mysqli_fetch_array($result);

// Check if the form is submitted
if (isset($_POST['updateBtn'])) {

    // Sanitize the input to prevent SQL injection
    $food_name = mysqli_real_escape_string($connection, $_POST['food_name']);
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
    $cal_count = mysqli_real_escape_string($connection, $_POST['cal_count']);

    // Execute the query to update the record
    $query = "UPDATE calc_table SET food_name = '$food_name', quantity = '$quantity', cal_count = '$cal_count' WHERE id = '$id'";
    $result = mysqli_query($connection, $query);

    // Check if query is successful
    if (!$result) {
        die('Query failed ' . mysqli_error($connection));
    }

    // Close the connection
    mysqli_close($connection);

    // Redirect the user back to the page that displays all the records
    header("Location: calculator.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Group 4">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <title><?php echo $page_title; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>    

    <link rel="stylesheet" href="css/designss.css">

    <style>
        body {
            background-image: url('images/foodbg.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>
<body>

    <br>

    <div class="ufooddatatable">
        <h1>Update Food Data</h1>
        <hr>
        <form method="POST">
            <div class="mb-3">
                <label for="food_name" class="form-label text-end fs-5">Food Name:</label>
                <div class="d-flex justify-content-start">
                    <input type="text" class="form-control text-start" id="food_name" name="food_name" value="<?php echo htmlspecialchars($row['food_name']); ?>">
                </div>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label text-end fs-5">Quantity:</label>
                <div class="d-flex justify-content-start">
                    <input type="text" class="form-control text-start" id="quantity" name="quantity" value="<?php echo htmlspecialchars($row['quantity']); ?>">
                </div>
            </div>
            <div class="mb-3">
                <label for="cal_count" class="form-label text-end fs-5">Calories:</label>
                <div class="d-flex justify-content-start">
                    <input type="text" class="form-control text-start" id="cal_count" name="cal_count" value="<?php echo htmlspecialchars($row['cal_count']); ?>">
                </div>
            </div>
            <div class="text-center">
                <input type="submit" name="updateBtn" value="Update" class="btn btn-primary btn-xl">
                <a href="calculator.php" class="btn btn-danger btn-xl">Return</a>
            </div>
        </form>
    </div>

    <?php include ('footer.html'); ?>

</body>
</html>
