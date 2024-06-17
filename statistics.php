<?php
session_start();
require 'connection.php';
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
     $page_title = 'Statistic Page';
    include ('header.html');
   

    // Check for connection errors
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get the total calorie intake per day for the current week
    $query_week = "SELECT 
                        'Monday' AS day_of_week, 
                        SUM(cal_count * quantity) AS total_calories 
                   FROM 
                        calc_table 
                   WHERE 
                        DAYNAME(date_added) = 'Monday'
                   UNION
                   SELECT 
                        'Tuesday' AS day_of_week, 
                        SUM(cal_count * quantity) AS total_calories 
                   FROM 
                        calc_table 
                   WHERE 
                        DAYNAME(date_added) = 'Tuesday'
                   UNION
                   SELECT 
                        'Wednesday' AS day_of_week, 
                        SUM(cal_count * quantity) AS total_calories 
                   FROM 
                        calc_table 
                   WHERE 
                        DAYNAME(date_added) = 'Wednesday'
                   UNION
                   SELECT 
                        'Thursday' AS day_of_week, 
                        SUM(cal_count * quantity) AS total_calories 
                   FROM 
                        calc_table 
                   WHERE 
                        DAYNAME(date_added) = 'Thursday'
                   UNION
                   SELECT 
                        'Friday' AS day_of_week, 
                        SUM(cal_count * quantity) AS total_calories 
                   FROM 
                        calc_table 
                   WHERE 
                        DAYNAME(date_added) = 'Friday'
                   UNION
                   SELECT 
                        'Saturday' AS day_of_week, 
                        SUM(cal_count * quantity) AS total_calories 
                   FROM 
                        calc_table 
                   WHERE 
                        DAYNAME(date_added) = 'Saturday'
                   UNION
                   SELECT 
                        'Sunday' AS day_of_week, 
                        SUM(cal_count * quantity) AS total_calories 
                   FROM 
                        calc_table 
                   WHERE 
                        DAYNAME(date_added) = 'Sunday'";

    $result_week = mysqli_query($connection, $query_week);

    // Check for query errors
    if (!$result_week) {
        die("Query failed: " . mysqli_error($connection));
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calorie Intake Tracker</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <style>
        body {
            background-image: url('images/foodbg.png');
        }
        
    caption {
        border-top: 1px solid #ddd;
        padding-top: 10px;
        text-align: center;
    }

    </style>

</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Weekly Calorie Intake</h1>
                <table class="table table-striped mt-3" style="background-color: white;">
                    <thead>
                        <tr>
                            <th>Day of Week</th>
                            <th>Total Calories</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row_week = mysqli_fetch_assoc($result_week)) { ?>
                            <tr>
                                <td><?php echo $row_week['day_of_week']; ?></td>
                                <td><?php echo $row_week['total_calories']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

<?php
    // Close the database connection
    mysqli_close($connection);
?>
