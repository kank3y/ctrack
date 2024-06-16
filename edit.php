<?php
		$page_title = 'Edit Page';
		include ('includes/header.html');
    require_once 'config/connection.php';

    $id = $_GET['id'];

		$query = "SELECT * FROM foodtable WHERE id='$id'";
		$sql = mysqli_query($connection, $query);

		if (isset($_POST['updateForm'])) {
		$id = $_POST['id'];

		$food_name = $_POST['food_name'];
		$quantity = $_POST['quantity'];
		$cal_count = $_POST['cal_count'];

		$updateQuery = "UPDATE foodtable SET food_name='$food_name', quantity='$quantity',
		cal_count='$cal_count' WHERE id='$id' ";

		mysqli_query($connection, $updateQuery);
		header('location: view.php');
	}
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Group 4">
    <meta name="keywords" content="HTML, CSS, JavaScript">

    <link rel="stylesheet" href="css/css.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>	

    <style>
    	body {

    		background-image: url('images/foodbg.png');
    		background-repeat: no-repeat;background-attachment: fixed;
    		background-size: cover;
    	}
    	
    </style>

</head>
<body>

	<br>

	<div class="ufooddatatable">
        <h1>Update Food Data</h1>
        <p> You selected ___. Please fill this form to update the selected food data.</p>
        <hr>
        <form action="edit.php" method="POST">
					<?php while($row = mysqli_fetch_array($sql)){ ?>
						<input type="text" name="id" value="<?php echo $row['id']; ?> "hidden><br><br>
						<h4>Food</h4>
						<input type="text" name="food_name" value="<?php echo $row['food_name']; ?> "><br><br>
						<h4>Quantity</h4>
						<input type="text" name="quantity" value="<?php echo $row['quantity']; ?>"><br><br>
						<h4>Calories</h3>
						<input type="text" name="cal_count" value="<?php echo $row['cal_count']; ?>"><br><br>

						<input type="submit" name="updateForm" class="updateForm" value="Update"><br><br>
		<?php } ?>
	</form>

</div>

	<?php include 'includes/footer.html'; ?>

</body>
</html>