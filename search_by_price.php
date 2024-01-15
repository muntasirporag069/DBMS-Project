<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Searched Gyms List</title>
    <link rel="stylesheet" type="text/css" href="AfterSearch.css">
</head>
<body>
<?php

    // Database configuration
    $host = "localhost/XE";
    $username = "DBMS"; // Replace with your database username
    $password = "123"; // Replace with your database password

    // Establish a connection to Oracle
    $conn = oci_connect($username, $password, $host);

    // Check the connection
    if (!$conn) {
        $e = oci_error();
        die("Connection failed: " . $e['message']);
    }

    if (isset($_GET['search'])) {

        $search = $_GET['search'];
        // Prepare the SQL query
        $query = "SELECT GYM_ID, GYM_NAME, AREA, CONTACT_NO FROM GYM NATURAL JOIN OFFERS WHERE PRICE <= :search GROUP BY GYM_ID,GYM_NAME,AREA,CONTACT_NO";

        $stid = oci_parse($conn, $query);

        // Bind the parameter
        oci_bind_by_name($stid, ":search", $search);

        // Execute the statement
        $r = oci_execute($stid);

        if (!$r) {
            $m = oci_error($stid);
            trigger_error('Could not execute statement: ' . $m['message'], E_USER_ERROR);
        }
    }

?>

    <header>
      
        <p class="something" style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;font-size:xx-large" >
            Gyms with Packages in this Price Range:<br>            
        </p>
   
        <br><br><br>
        <br><br><br><br>
    
        <table>
            <caption class="caption1"><b>Gyms</b></caption><br>
            <thead>
              <tr>
                <th>Gym Name</th>
                <th>Location</th>
                <th>Contact</th>
              </tr>
            </thead>
            <tbody>
                <?php
                while ($row = oci_fetch_assoc($stid))
                {                
                    echo '<tr>';
                    echo '<td><a href="genericGymPage.php?id=' . $row['GYM_ID'] . '">' . $row['GYM_NAME'] . '</a></td>';
                    echo '<td>' . $row['AREA'] . '</td>';
                    echo '<td>' . $row['CONTACT_NO'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table><br><br>
          
        <br><br><br><br><br><br>

    
</body>
</html>
