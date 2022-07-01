<?php 

$page_title = 'Edit Department'; 
include('includes/header.php');

 // Check for a valid user id, through get or post
if ((isset($_GET['id'])) && (is_numeric($_GET['id'])) ){
    $id = $_GET['id'];
    // echo "<p> Get id is found and is $id (9)</p>";
} 
elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ){
    $id = $_POST['id'];
} 
else {
    echo "<p> This page has been accessed in error (line 14)</p>";
    include('includes/footer.php');
    exit();
 }

require('db.php'); // connect to the db

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //this checks that the form was submitted using the POST method

    $errors = []; // Initialize an error array.

	// Check for a first name:
    if (empty($_POST['department_name'])) {//if first name field is empty
		$errors[] = 'You forgot to enter the department name.'; //push the error array containing this message
	} 
    else { //if not empty
		$dn = mysqli_real_escape_string($dbc, trim($_POST['department_name'])); 
	}
	
	// Check for a last name:
	if (empty($_POST['num_employees'])) {
		$errors[] = 'You forgot to enter the number of employees.';
	} 
    else {
	    $ne = mysqli_real_escape_string($dbc, trim($_POST['num_employees']));
	}

	// Check for an email address:
	if (empty($_POST['region_code'])) {
		$errors[] = 'You forgot to enter the region code.';
	} 
    else {
		$rc = mysqli_real_escape_string($dbc, trim($_POST['region_code']));
	}

	if (empty($errors)) { // If everything's OK.
	
	 // Update the user in the database...
     //test for unique email address
        $q = "SELECT department_id FROM DEPARTMENT WHERE department_name='$dn' AND user_id != $id";
        $r = @mysqli_query($dbc, $q);
        if (mysqli_num_rows($r) == 0){
            
		    $q = "UPDATE DEPARTMENT SET department_name='$dn', num_employees='$ne', region_code='$rc' WHERE department_id=$id LIMIT 1";		
		    $r = @mysqli_query($dbc, $q); // Run the query.

                if (mysqli_affected_rows($dbc) == 1){
                //print a message
                echo "<p> The department has been edited</p>";
                } 
                else { //if it did not run okay
                echo '<p> The department could not be edited due to a system error</p>'; //error mssg 
                //echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $q . '</p>'; //dbg message
                } 
        } 
        else { //already registered
        echo "<p>This department has already been registered.</p>";
        }
    }
    else {
        echo '<p> The following errors occured:</p>';
        foreach ($errors as $msg){
            echo " - $msg<br>\n";
        }
        echo '<p>Please Try Again</p>';
    } //end of if empty errors

} //end of main submit conditional

  //always show the form

  //retrive user info
    $q = "SELECT department_name, num_employees, region_code FROM DEPARTMENT WHERE department_id=$id";
    // echo "<p>$q (89)</p>";
    $r = @mysqli_query($dbc, $q);

    if (mysqli_num_rows($r) == 1){ //valid user id, show form
        // echo "<p>user found. getting information (93)</p>";
        //get user info
        $row = mysqli_fetch_array($r, MYSQLI_NUM);

        //create the form:
            echo "<main>";
            echo '<form action="edit_department.php" method="post">
            <h2>Edit Department</h2>
            <p>Dept Name: <input type="text" name="department_name" size="15" maxlength="15" value="' . $row[0] . '"></p>
            <p># of Employees: <input type="number" name="num_employees" size="15" maxlength="30" value="' . $row[1] . '"></p>
            <p>Region Number: <input type="number" name="region_code" size="20" maxlength="60" value="' . $row[2] . '"> </p>
            <p><input type="submit" name="submit" value="Submit"></p>
            <input type="hidden" name="id" value="' . $id . '">
            </form>';
            echo "</main>";
    }
    else { // not a valid user id
        echo '<p> This page has been accessed in error</p> (103)';
    }

    mysqli_close($dbc); // Close the database connection.
    include('includes/footer.php');
?>