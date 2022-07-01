<?php 

$page_title = 'Edit User'; 
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
    if (empty($_POST['first_name'])) {//if first name field is empty
		$errors[] = 'You forgot to enter your first name.'; //push the error array containing this message
	} 
    else { //if not empty
		$fn = mysqli_real_escape_string($dbc, trim($_POST['first_name'])); //set the variable $fn 
	}
	
	// Check for a last name:
	if (empty($_POST['last_name'])) {
		$errors[] = 'You forgot to enter your last name.';
	} 
    else {
	    $ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	}

	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} 
    else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}

	if (empty($errors)) { // If everything's OK.
	
	 // Update the user in the database...
     //test for unique email address
        $q = "SELECT user_id FROM USER WHERE email_address='$e' AND user_id != $id";
        $r = @mysqli_query($dbc, $q);
        if (mysqli_num_rows($r) == 0){
            // echo "<p>email does not exist. updating record (57)";
		// Make the query:
		    $q = "UPDATE USER SET first_name='$fn', last_name='$ln', email_address='$e' WHERE user_id=$id LIMIT 1";		
		    $r = @mysqli_query($dbc, $q); // Run the query.

                if (mysqli_affected_rows($dbc) == 1){
                //print a message
                echo "<p> The user has been edited</p>";
                } 
                else { //if it did not run okay
                echo '<p> The user could not be edited due to a system error</p>'; //error mssg 
                // echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $q . '</p>'; //dbg message
                } 
        } 
        else { //already registered
        echo "<p>The email address has already been registered.</p>";
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
    $q = "SELECT first_name, last_name, email_address FROM USER WHERE user_id=$id";
    // echo "<p>$q (89)</p>";
    $r = @mysqli_query($dbc, $q);

    if (mysqli_num_rows($r) == 1){ //valid user id, show form
        // echo "<p>user found. getting information (93)</p>";
        //get user info
        $row = mysqli_fetch_array($r, MYSQLI_NUM);

        //create the form:
            echo "<main>";
            echo '<form action="edit_user.php" method="post">
            <h2>Edit Employee Credentials</h2>
            <p>First Name: <input type="text" name="first_name" size="15" maxlength="15" value="' . $row[0] . '"></p>
            <p>Last Name: <input type="text" name="last_name" size="15" maxlength="30" value="' . $row[1] . '"></p>
            <p>Email Address: <input type="email" name="email" size="20" maxlength="60" value="' . $row[2] . '"> </p>
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