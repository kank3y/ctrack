<?php
require_once __DIR__ . '/../config/constants.php';

// Create connection
$connection = mysqli_init();
mysqli_ssl_set($connection, NULL, NULL, "DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($connection, "calorietracker.mysql.database.azure.com", "calorietracker", "!ctracker1234", "ctrackerdb", 3306);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}
?>
