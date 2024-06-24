<?php
	$page_title = 'Delete Page';
	include ('header.html');
	require 'connection.php';


	// Get the id of the record to delete
$id = mysqli_real_escape_string($connection, $_GET['id']);

// Execute the query to delete the record
$query = "DELETE FROM calc_table WHERE id = '$id'";
$result = mysqli_query($connection, $query);

// Check if query is successful
if(!$result) {
  die('Query failed ' . mysqli_error($connection));
}

echo "<div class='alert alert-success text-center'>Record deleted successfully! Go back to calculator page.</div>";
// Redirect the user back to the page that displays all the records
header("Location: calculator.php");
exit();
?>
