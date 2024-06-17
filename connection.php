<?php
$connection = mysqli_init();
mysqli_ssl_set($connection,NULL,NULL, "/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($connection, "calorietracker.mysql.database.azure.com", "calorietracker", "!ctracker1234", "ctrackerdb", 3306, MYSQLI_CLIENT_SSL);
?>
