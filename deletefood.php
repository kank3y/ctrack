<?php
	$page_title = 'Delete Page';
	include ('includes/header.html');
	require_once 'config/connection.php';
	
	$id = $_GET['id'];
	
	$sql = "DELETE FROM ctrackerdb.calc_table WHERE id='$id' ";	
	$result = mysqli_query($connection, $sql);
	
	if ($result == TRUE) 
		{
			header('location: calculator.php');
			exit();
		}
?>