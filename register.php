<?php 


$page_title = 'Add User'; //sets pagetitle variable within header
include('includes/header.php'); //this is the header include file.



if ($_SERVER['REQUEST_METHOD'] == 'POST') { //this checks that the form was submitted using the POST method


    require('db.php'); // connect to the db TESTED- SUCCESS

	$errors = []; // Initialize an error array.

	// Check for a first name:
	if (empty($_POST['first_name'])) {//if first name field is empty
		$errors[] = 'You forgot to enter your first name.'; //push the error array containing this message
	} else { //if not empty
		$fn = mysqli_real_escape_string($dbc, trim($_POST['first_name'])); //set the variable $fn 
	}
	/*
	mysqli_real_escape_string:
	This function is used to create a legal SQL string 
	that you can use in an SQL statement. The given 
	string is encoded to produce an escaped SQL string, 
	taking into account the current character set of the connection.
	
	*/ 

	// Check for a last name:
	if (empty($_POST['last_name'])) {
		$errors[] = 'You forgot to enter your last name.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	}

	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}

	

	if (empty($errors)) { // If everything's OK.

		//Add employee quantity based on user selection
	
	

		// Register the user in the database...

		// Make the query:
		$q = "INSERT INTO USER (first_name, last_name, email_address, password) VALUES ('$fn', '$ln', '$e', SHA2('$p', 512))";
		$qd = "INSERT INTO DEPARTMENT (department_name, region_code, num_of_employees) VALUES ('$DN', '$R', $empQuant)";
		$r = @mysqli_query($dbc, $q); // Run the query.

		if ($r) { // If it ran OK.
			// Print a message:
			echo "<main class='r-main'>";
			echo "<section class='regdiv'>";
			echo '<h2>REGISTRATION SUCCESS</h2>
		<p>You are now a registered employee of the Umbrella Corporation.</p>';
			echo "</section>";
			echo "</main>";
		} else { // If it did not run OK.
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
		} // End of if ($r) IF.

		mysqli_close($dbc); // Close the database connection.
		// Include the footer and quit the script:
		include('includes/footer.html');
		exit();
	} else { // Report the errors.
        echo "<div class='errorscreen'>";
		echo '<h2>Error!</h2>
		<p class="error">The following error(s) occurred:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><p>Please try again.</p><p><br></p>';
        echo "</div>";

	} // End of if (empty($errors)) IF.

	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.

?>

<main>

<form action="register.php" method="post">
<h2>Add Employee</h2>
	<p><label for="first_name">First Name: </label><input type="text" name="first_name" size="15" maxlength="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>"></p>
	<p><label for="last_name">Last Name:</label><input type="text" name="last_name" size="15" maxlength="40" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>"></p>
	<p><label for="email">Email Address:</label><input type="email" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" > </p>
	

	<p><input type="checkbox" name="confirminfo" value="1" required> Confirm that this information is correct</p>
    
    <p class="centersubmit"><input type="submit" name="submit" value="Register"></p>
</form>
</main>

<?php include('includes/footer.php'); ?>