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
$username = "DBMS";
$password = "123";
$conn = oci_connect($username, $password, $host);


if (!$conn) {
    $e = oci_error();
    die("Connection failed: " . $e['message']);
}
//                              DYNAMIC SEARCH AND IN-BUILT FUCNTION
if (isset($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%';

    $query = "SELECT GYM_ID, GYM_NAME, AREA, SPECIALIZATION, CONTACT_NO FROM GYM WHERE UPPER(Specialization) LIKE UPPER(:search)";

    $stid = oci_parse($conn, $query);

    
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
            Gyms with Searched Specialization:<br>            
        </p>
   
        <br><br><br>
        <br><br><br><br>
    
        <table>
            <caption class="caption1"><b>Gyms</b></caption><br>
            <thead>
              <tr>
                <th>Gym Name</th>
                <th>Location</th>
                <th>Specialization</th>
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
                    echo '<td>' . $row['SPECIALIZATION'] . '</td>';
                    echo '<td>' . $row['CONTACT_NO'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table><br><br>
          
        <br><br><br><br><br><br>

        <br><p  class="retHome"><b><a href="HomePage.html">Return to Homepage</a></b></p>
    
</body>
</html>
