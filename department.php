<?php 


$page_title = 'Umbrella Corporation Add Department'; //sets pagetitle variable within header
include('includes/header.php'); //this is the header include file.



if ($_SERVER['REQUEST_METHOD'] == 'POST') { //this checks that the form was submitted using the POST method

	require('db.php'); // connect to the db TESTED- SUCCESS

	$errors = []; // Initialize an error array.

	//check dept name
	if (empty($_POST['deptname'])) {
		$errors[] = 'You forgot to enter the department name'; //push the error array containing this message
	} else { //if not empty
		$dn = mysqli_real_escape_string($dbc, trim($_POST['deptname'])); //set the variable $fn 
	}#
	
	// Check num_employees
	if (empty($_POST['num_employees'])) {
		$errors[] = 'You forgot to enter the employee quantity';
	} else {
		$eq = mysqli_real_escape_string($dbc, trim($_POST['num_employees']));
	}#

	// Check for region number
	if (empty($_POST['region_number'])) {
		$errors[] = 'You forgot to enter the region code.';
	} else {
		$rc = mysqli_real_escape_string($dbc, trim($_POST['region_number']));
	}#

	if (empty($errors)) { // If everything's OK.

		// Register the user in the database...

		// Make the query:
		$q = "INSERT INTO DEPARTMENT (department_name, num_employees, region_code) VALUES ('$dn', '$eq', '$rc')";
		$r = @mysqli_query($dbc, $q); // Run the query.

		if ($r) { // If it ran OK.
			// Print a message:
			echo "<main class='r-main'>";
			echo "<section class='regdiv'>";
			echo '<h2>SUCCESS</h2>
		<p>You have successfully updated the Umbrella Corporation company system.</p>';
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

<form action="department.php" method="post">
<h2>DEPARTMENT REGISTRATION</h2>
	<p><label for="dept_name">Deparment Name: </label><input type="text" name="deptname" size="30" maxlength="40" value="<?php if (isset($_POST['deptname'])) echo $_POST['deptname']; ?>"></p>
	<p><label for="num_employees">Number of Employees:</label><input type="number" max="999" min="200" name="num_employees" size="30" maxlength="40" value="<?php if (isset($_POST['num_employees'])) echo $_POST['num_employees']; ?>"></p>
	<p><label for="region_number">Region Number:</label><input type="number" min="1010" max="3000" name="region_number" size="30" maxlength="40" value="<?php if (isset($_POST['region_number'])) echo $_POST['region_number']; ?>" > </p>
	<p><input type="checkbox" name="confirminfo" value="1" required> Confirm that this information is correct</p>
    
    <p class="centersubmit"><input type="submit" name="submit" value="Register"></p>
</form>
</main>

<?php include('includes/footer.php'); ?>