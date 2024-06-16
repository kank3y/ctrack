<?php
  session_start();
include ('includes/header_index.html');
    require_once 'config/connection.php';

    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
	$page_title = 'Home Page';
	include ('includes/header.html');
	require_once 'config/connection.php';

	// SQL statement
	$sql = "SELECT * FROM ctrackerdb.calc_table";
	$display_specific = "SELECT id, food_name, quantity, cal_count FROM calc_table";
	$query = mysqli_query($connection, $sql);
	// Logic for RegForm
	$errors = array();

	if(isset($_POST['submitForm'])) {
		$fname = $_POST['food_name'];
		$qty = $_POST['quantity'];
		$c_count = $_POST['cal_count'];
    $username = $_SESSION["username"];

		// Validation of data if empty
		if (empty($fname)) {
			$errors['food_name'] = "Please Enter Food!";
		}
		
		if (empty($qty)) {
			$errors['quantity'] = "Please Enter Quantity!";
		}

		if (empty($c_count)) {
			$errors['cal_count'] = "Please Enter Calories!";
		}


		
		if (count($errors) == 0) {
			$createQuery = "INSERT INTO calc_table (food_name, quantity, cal_count, username) VALUES (?, ?, ?, ?)";

			$stmt = $connection->prepare($createQuery);
			$stmt->bind_param('siis', $fname, $qty, $c_count, $username);

			if ($stmt->execute()) {
				header('location: calculator.php');
			}
			else {
				$error['db_error'] = "Database Error: Failed to Insert Food Data.";
			}
		}

	}
?>


<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Group 4">
    <meta name="keywords" content="HTML, CSS, JavaScript">


    <script>
		function fillInputs(dropdown) {
			var selectedOption = dropdown.options[dropdown.selectedIndex].value;
			if(selectedOption) {
				var selectedData = selectedOption.split('|');
				document.getElementById('food_name').value = selectedData[0];
				document.getElementById('quantity').value = selectedData[1];
				document.getElementById('cal_count').value = selectedData[2];
			} else {
				document.getElementById('food_name').value = '';
				document.getElementById('quantity').value = '';
				document.getElementById('cal_count').value = '';
			}
		}
	</script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>	

    <link rel="stylesheet" href="css/designss.css">

    <style>
    	body {

    		background-image: url('images/foodbg.png');
    		background-repeat: no-repeat;background-attachment: fixed;
    		background-size: cover;
    	}
    	

    .container {
    position: relative;
  }

  .pagination-nav {
    position: absolute;
    top: -58px;
    left: 14px;

  }

    .total-calories-box {
        border: 2px solid #ddd;
        padding: 10px;
        margin-bottom: 20px;
        background-color: #f2f2f2;
        font-family: 'Helvetica Neue', sans-serif;
        text-align: center;

        width: 225px;
    }

    .total-calories h2 {
        margin-bottom: 10px;
        font-size: 20px;
        font-weight: bold;
    }

    .total-calories p {
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }
    </style>

</head>

<body>

	<br>

<div class="container" style="max-width: 900px;">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="efooddatatable p-4">
        <h1>Food Data</h1>
        <p>Please fill this form to add a food data into the table.</p>
        <hr>
        <form action="calculator.php" method="POST">

          <div class="mb-3">
            <label for="dropdown" class="form-label">Select Food</label>
            <select name="dropdown" onchange="fillInputs(this)" class="form-select">
              <option value="">-- Select Food --</option>
              <?php
              // Retrieve data from table
              $sql = "SELECT * FROM predef_food";
              $result = mysqli_query($connection, $sql);

              // Populate dropdown button with data
              while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="'.$row['food_name'].'|'.$row['quantity'].'|'.$row['cal_count'].'">'.$row['food_name'].'</option>';
              }

              // Close database connection
              mysqli_close($connection);
              ?>
            </select>
          </div>

    <div class="mb-3">
      <label for="food_name" class="form-label">Food</label>
      <input type="text" name="food_name" id="food_name" placeholder="Enter Food..." class="form-control <?php echo isset($errors['food_name']) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['food_name']) ? $_POST['food_name'] : ''; ?>">
      <?php if(isset($errors['food_name'])) : ?>
        <div class="invalid-feedback text-start"><?php echo $errors['food_name']; ?></div>
      <?php endif; ?>
    </div>

    <div class="mb-3">
      <label for="quantity" class="form-label">Quantity</label>
      <input type="text" name="quantity" id="quantity" placeholder="Enter Quantity..." class="form-control <?php echo isset($errors['quantity']) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['quantity']) ? $_POST['quantity'] : ''; ?>">
      <?php if(isset($errors['quantity'])) : ?>
        <div class="invalid-feedback text-start"><?php echo $errors['quantity']; ?></div>
      <?php endif; ?>
    </div>

    <div class="mb-3">
      <label for="cal_count" class="form-label">Calories</label>
      <input type="text" name="cal_count" id="cal_count" placeholder="Enter Calories..." class="form-control <?php echo isset($errors['cal_count']) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['cal_count']) ? $_POST['cal_count'] : ''; ?>">
      <?php if(isset($errors['cal_count'])) : ?>
        <div class="invalid-feedback text-start"><?php echo $errors['cal_count']; ?></div>
      <?php endif; ?>
    </div>
          <button type="submit" name="submitForm" class="btn btn-primary">Submit Food Data</button>
        </form>
      </div>
    </div>
  </div>
</div>
 <br>
    <div class="fooddatatable">
        <h1 class= "LOF">List of Added Food Data</h1>
        <hr>
        <div class="divSearch">
       <form class="d-flex justify-content-end" action="search.php" method="get">
    </form>
    <div class="d-flex justify-content-end">
  <form class="d-flex" method="POST">
    <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" style= "max-width:200px">
    <button class="btn btn-primary me-3" name="searchBtn" type="submit">Search</button>

  </form>
</div>
</div>

<?php
  $db_server = "calorietracker.mysql.database.azure.com";
  $db_username = "calorietracker";
  $db_password = "!ctracker1234";
  $db_name = "ctrackerdb";

// Establish connection to Azure MySQL
  $connection = mysqli_init();
  mysqli_ssl_set($connection,NULL,NULL, "DigiCertGlobalRootCA.crt.pem", NULL, NULL);
  mysqli_real_connect($connection, $db_server, $db_username, $db_password, $db_name, 3306, NULL);

  // Check connection
  if (mysqli_connect_errno()) {
      die('Database connection failed ' . mysqli_connect_error());
  }

  // Select the database
  $db_selected = mysqli_select_db($connection, $db_name);

  // Check if database selection succeeded
  if (!$db_selected) {
      die ('Can\'t use the selected database : ' . mysqli_error($connection));
  }

  // Get the username from the session

  $username = $_SESSION["username"];

  $query = "SELECT SUM(cal_count * quantity) as totalcal FROM calc_table WHERE username = '$username'";
  $total = mysqli_query($connection, $query);

  if ($total) {
      $row = mysqli_fetch_assoc($total);
      $totalcal = $row['totalcal'];
}
?>



  


<?php
// Check if the form is submitted
if(isset($_POST['searchBtn'])) {

    // Check if the search input field is empty
    if(empty($_POST['search'])) {
        echo "Field cannot be empty.";
        echo "<br>";
        echo "<button onclick='history.back()' class='btn btn-secondary'>Return</button>";
        exit;
    }

    // Database connection details for Azure MySQL
    $db_server = "calorietracker.mysql.database.azure.com";
    $db_username = "calorietracker@calorietracker";
    $db_password = "!ctracker1234";
    $db_name = "ctrackerdb";

    // Establish connection to Azure MySQL
    $connection = mysqli_init();
    mysqli_ssl_set($connection, NULL, NULL, "DigiCertGlobalRootCA.crt.pem", NULL, NULL);
    mysqli_real_connect($connection, $db_server, $db_username, $db_password, $db_name, 3306, NULL);

    // Check connection
    if (mysqli_connect_errno()) {
        die('Database connection failed ' . mysqli_connect_error());
    }

    // Sanitize the search input to prevent SQL injection
    $search = mysqli_real_escape_string($connection, $_POST['search']);

    // Execute the query to search the database
    $query = "SELECT * FROM calc_table WHERE food_name LIKE '%$search%'";
    $result = mysqli_query($connection, $query);

    // Check if query is successful
    if(!$result) {
        die('Query failed ' . mysqli_error($connection));
    }

    // Check if there are any results
    if(mysqli_num_rows($result) == 0) {
        echo "<p>Data does not exist</p>";
        echo "<button onclick='history.back()' class='btn btn-secondary'>Return</button>";
        echo "<br>";
    }
    else {
        echo "<br>";  
        echo "<table class='table table-striped table-bordered table-hover'>";
        echo "<tr><th>Food Name</th><th>Quantity</th><th>Calories</th><th>Day</th><th>--</th><th>--</th></tr>";
        // Loop through the results and display them
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['food_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
            echo "<td>" . htmlspecialchars($row['cal_count']) . "</td>";
            echo "<td>" . htmlspecialchars(date('l', strtotime($row['date_added']))) . "</td>";
            echo "<td><a href='updatefood.php?id=" . $row['id'] . "' class='btn btn-primary'>Update</a></td>";
            echo "<td><a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this data?\")' class='btn btn-danger'>Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";

        // Add a button to go back to the calculator.php page
        echo "<form action='calculator.php' method='GET'>";
        echo "<input type='hidden' name='search' value='" . htmlspecialchars($search) . "'>"; 
        echo "<button type='submit' name='backBtn' class='btn btn-secondary'>Back</button>";
        echo "</form>";
    }

    // Close the connection
    mysqli_close($connection);
}
?>


<br>
<div class="container">
  <div class="table-responsive-xxl">
    <table class="table table-striped table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>Food Name</th>
          <th>Quantity</th>
          <th>Calories</th>
          <th>Day</th>
          <th>--</th>
          <th>--</th>

        </tr>
      </thead>
      <tbody>

<?php


// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit;
}

  $db_server = "calorietracker.mysql.database.azure.com";
  $db_username = "calorietracker";
  $db_password = "!ctracker1234";
  $db_name = "ctrackerdb";

// Create a connection to the database
$connection = mysqli_init();
mysqli_ssl_set($connection, NULL, NULL, "DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($connection, $db_server, $db_username, $db_password, $db_name, 3306);

// Check if connection is successful
if (mysqli_connect_errno()) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Get the username from the session (assuming it's previously set securely)
$username = $_SESSION["username"];

// Define how many records to display per page
$records_per_page = 5;

// Get the current page number from the URL query string
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the current page
$offset = ($page - 1) * $records_per_page;

// Prepare the query to select records with limit and offset, filtered by username
$query = "SELECT *, DATE_FORMAT(date_added, '%W') AS day FROM calc_table WHERE username = ? LIMIT ?, ?";
$stmt = mysqli_prepare($connection, $query);

// Bind parameters to the prepared statement
mysqli_stmt_bind_param($stmt, "sii", $username, $offset, $records_per_page);

// Execute the prepared statement
mysqli_stmt_execute($stmt);

// Get result set from the prepared statement
$result = mysqli_stmt_get_result($stmt);

// Check if query execution was successful
if(!$result) {
    die('Query failed ' . mysqli_error($connection));
}

// Get the total number of records for the logged-in user
$total_records_query = "SELECT COUNT(*) FROM calc_table WHERE username = ?";
$total_records_stmt = mysqli_prepare($connection, $total_records_query);

// Bind parameter for the total records prepared statement
mysqli_stmt_bind_param($total_records_stmt, "s", $username);

// Execute the total records prepared statement
mysqli_stmt_execute($total_records_stmt);

// Get result set from the total records prepared statement
$total_records_result = mysqli_stmt_get_result($total_records_stmt);

// Fetch total number of records as integer from the result set
$total_records = mysqli_fetch_array($total_records_result)[0];

// Calculate the total number of pages needed for pagination
$total_pages = ceil($total_records / $records_per_page);

// Initialize total calories counter
$total_calories = 0;

// Check if there are any records returned
if(mysqli_num_rows($result) == 0) {
    echo "<tr><td colspan='6'>No records found.</td></tr>";
} else {
    // Loop through the result set and display records in a table
    while($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['food_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
        echo "<td>" . htmlspecialchars($row['cal_count']) . "</td>";
        echo "<td>" . htmlspecialchars($row['day']) . "</td>";
        echo "<td><a href='updatefood.php?id=" . $row['id'] . "' class='btn btn-primary'>Update</a></td>";
        echo "<td><a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this data?\")' class='btn btn-danger'>Delete</a></td>";
        echo "</tr>";

        // Accumulate calorie count to calculate total calories
        $total_calories += $row['cal_count'];
    }
}

// Close prepared statements
mysqli_stmt_close($stmt);
mysqli_stmt_close($total_records_stmt);

// Close database connection
mysqli_close($connection);
?>





<nav aria-label="Page navigation" class="pagination-nav">
    <ul class="pagination justify-content-start">
      <?php if ($page > 1) : ?>
        <li class="page-item"><a class="page-link" href="?page=<?php echo ($page - 1); ?>">Previous</a></li>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
        <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
      <?php endfor; ?>

      <?php if ($page < $total_pages) : ?>
        <li class="page-item"><a class="page-link" href="?page=<?php echo ($page + 1); ?>">Next</a></li>
      <?php endif; ?>
    </ul>
  </nav>
      </tbody>

  </div>
</div>
</table>

<div class="container d-flex justify-content-end">
  <div class="total-calories-box">
    <div class="total-calories">
      <h2>Total Calories:</h2>
      <p><?php echo $totalcal; ?></p>
    </div>
  </div>
</div>
  </div>
</div>
<br>
     
      </tbody>
    </table>
  </div>
  
</div>
	<?php include 'includes/footer.html'; ?>

</body>
</html>
