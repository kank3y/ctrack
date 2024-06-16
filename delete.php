<?php
	$page_title = 'Delete Page';
	include ('includes/header.html');
	require_once 'config/connection.php';


	// Get the id of the record to delete
$id = mysqli_real_escape_string($connection, $_GET['id']);

// Execute the query to delete the record
$query = "DELETE FROM calc_table WHERE id = '$id'";
$result = mysqli_query($connection, $query);

// Check if query is successful
if(!$result) {
  die('Query failed ' . mysqli_error($connection));
}

// Redirect the user back to the page that displays all the records
header("Location: calculator.php");
exit();
?>