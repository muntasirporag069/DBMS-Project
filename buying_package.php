<?php
session_start();

$ID = $_SESSION['Current_User_ID'];
$GYMID = $_SESSION['Current_Gym_ID'];


if (isset($_GET['PACKAGE_ID'])) {
    
    $host = "//localhost/XE";
    $username = "DBMS"; // Replace with your database username
    $password = "123"; // Replace with your database password
    
    // Establish a connection to Oracle
    $conn = oci_connect($username, $password, $host);
    
    // Check the connection
    if (!$conn) {
        $e = oci_error();
        die("Connection failed: " . $e['message']);
    }

    $p_ID = $_GET['PACKAGE_ID'];
    $query1 = "SELECT DURATION FROM PACKAGE WHERE PACKAGE_ID = :p_ID";

    $stmt1 = oci_parse($conn,$query1);
    oci_bind_by_name($stmt1,":p_ID",$p_ID);
    $result1 = oci_execute($stmt1);
    if(!$result1){
        $m = oci_error($stmt1);
        trigger_error('Could not execute statement: ' . $m['message'], E_USER_ERROR);
    }
    $row = oci_fetch_assoc($stmt1);
    $duration = $row['DURATION'];
    
    $query2 = "INSERT INTO CHOOSE(GYM_ID,CLIENT_ID,PACKAGE_ID,DURATION) VALUES(:GYMID,:ID,:p_ID,:duration)";
    $stmt2 = oci_parse($conn,$query2);
    oci_bind_by_name($stmt2,":GYMID",$GYMID);
    oci_bind_by_name($stmt2,":ID",$ID);
    oci_bind_by_name($stmt2,":p_ID",$p_ID);
    oci_bind_by_name($stmt2,":duration",$duration);

    $result2 = oci_execute($stmt2);
    if(!$result2){
        $m = oci_error($stmt2);
        trigger_error('Could not execute statement: ' . $m['message'], E_USER_ERROR);
        
    }
    oci_free_statement($stmt1);
    oci_free_statement($stmt2);
    oci_close($conn);
        
    header("Location: Client_View.php");
    exit;

       
} 
else {
    echo "Package ID not provided";
}
?>