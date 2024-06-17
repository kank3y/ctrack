// Create a MySQLi object instance
$connection = mysqli_init();

// Set SSL options
if (!$connection) {
    die('mysqli_init failed');
}

if (!mysqli_ssl_set($connection, NULL, NULL, __DIR__ . '/DigiCertGlobalRootCA.crt.pem', NULL, NULL)) {
    die('Setting SSL failed');
}

// Connect to the database
if (!mysqli_real_connect($connection, "calorietracker.mysql.database.azure.com", "calorietracker", "!ctracker1234", "ctrackerdb", 3306, MYSQLI_CLIENT_SSL)) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

// Connection successful
echo 'Connected successfully';
