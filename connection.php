<?php
// Create a MySQLi object instance
$connection = mysqli_init();

// Set SSL options
if (!$connection) {
    die('mysqli_init failed');
}

// Path to your certificate file (assuming it's in the same directory as this script)
$cert_file = __DIR__ . '/DigiCertGlobalRootCA.crt.pem';

if (!mysqli_ssl_set($connection, NULL, NULL, $cert_file, NULL, NULL)) {
    die('Setting SSL failed');
}

// Database connection details
$servername = "calorietracker.mysql.database.azure.com";
$username = "calorietracker";
$password = "!ctracker1234";
$dbname = "ctrackerdb";
$port = 3306;

// Connect to the database
if (!mysqli_real_connect($connection, $servername, $username, $password, $dbname, $port, MYSQLI_CLIENT_SSL)) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

// Connection successful
echo 'Connected successfully';

// Perform your database operations here using $connection
// For example:
// $query = "SELECT * FROM your_table";
// $result = mysqli_query($connection, $query);
// while ($row = mysqli_fetch_assoc($result)) {
//     // Process each row
// }

// Close the connection
mysqli_close($connection);
?>
