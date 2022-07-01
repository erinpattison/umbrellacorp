<?php

$page_title = "Employee Management";
include('includes/header.php');
echo "<main>";
require('db.php');

echo "<section id='userlist'>";
echo "<h2>Employee Management</h2>";

//create a query and store to the $query variable
$query = "SELECT * FROM USER";

// OPen a db connection and run the query.
$result = mysqli_query($dbc, $query);

echo "<table>
<tr>
  <th>EMPLOYEE ID</th>
  <th>FIRST NAME</th>
  <th>LAST NAME</th>
  <th>EMAIL ADDRESS</TH>
</tr>";

while($row = mysqli_fetch_assoc($result)){
    echo "<tr><td><a href='edit_user.php?id=" . $row['user_id'] . "'>" . $row['user_id'] . "</a></td> <td>" . $row['first_name'] . "</td><td>" . $row['last_name'] . "</td><td>" . $row['email_address'] . "</td>";
    
}

echo "</table>";
echo "</section>";
echo "</main>";

include("includes/footer.php");
?>

 