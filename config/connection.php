<?php
require_once __DIR__ . '/../config/constants.php';

// Initialize connection
$connection = mysqli_init();

// Set SSL options if needed
mysqli_ssl_set($connection, NULL, NULL, "DigiCertGlobalRootCA.crt.pem", NULL, NULL);

// Attempt to connect to the database
mysqli_real_connect($connection, "calorietracker.mysql.database.azure.com", "calorietracker", "!ctracker1234", "ctrackerdb", 3306, MYSQLI_CLIENT_SSL);

// Check if connection was successful
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}
?>
