<?php
// Create a MySQLi object instance
$connection = mysqli_init();

// Set SSL options
if (!$connection) {
    die('mysqli_init failed');
}

// Replace 'DigiCertGlobalRootCA.crt.pem' with the correct path to your certificate file
$cert_file = __DIR__ . '/DigiCertGlobalRootCA.crt.pem';

if (!mysqli_ssl_set($connection, NULL, NULL, $cert_file, NULL, NULL)) {
    die('Setting SSL failed');
}

// Connect to the database
$servername = "calorietracker.mysql.database.azure.com";
$username = "calorietracker";
$password = "!ctracker1234";
$dbname = "ctrackerdb";
$port = 3306;

if (!mysqli_real_connect($connection, $servername, $username, $password, $dbname, $port, MYSQLI_CLIENT_SSL)) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

// Connection successful
echo 'Connected successfully';

// Perform your database operations here using $connection

// Close the connection
mysqli_close($connection);
?>
