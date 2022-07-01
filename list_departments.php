<?php

$page_title = "Umbrella Corporation DEPARTMENTS";
include('includes/header.php');
echo "<main>";
require('db.php');

echo "<section id='userlist'>";
echo "<h2 class='departmenth2'>Umbrella Corporation DEPARTMENTS</h2>";

//create a query and store to the $query variable
$query = "SELECT * FROM DEPARTMENT ORDER BY department_name ASC";

// OPen a db connection and run the query.
$result = mysqli_query($dbc, $query);

echo "<table>
<tr>
  <th>DEPARTMENT ID</th>
  <th>DEPARTMENT NAME</th>
  <th># OF EMPLOYEES</th>
  <th>REGION NUMBER</TH>
</tr>";

while($row = mysqli_fetch_assoc($result)){
    echo "<tr><td><a href='edit_department.php?id=" . $row['department_id'] . "'>" . $row['department_id'] . "</a></td> <td>" . $row['department_name'] . "</td><td>" . $row['num_employees'] . "</td><td>" . $row['region_code'] . "</td>";
    // echo "<p class='dbp'>" . $row['user_id'] . " " . $row['first_name'] . " " . $row['last_name'] . " " . $row['email_address'] . "</p>";
}

echo "</table>";
echo "</section>";
echo "</main>";

include("includes/footer.php");
?>
