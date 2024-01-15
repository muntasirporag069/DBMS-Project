<?php
session_start();
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $ClientID = $_POST['ClientID'];
    $dietplan = $_POST['dietplan'];

    $nutritionistID = $_SESSION['Current_User_ID'];

    // Prepare the SQL queries

    $query = "UPDATE PLANS SET DIET_PLAN = :dietplan WHERE CLIENT_ID = :ClientID";

    $stmt = oci_parse($conn,$query);
    oci_bind_by_name($stmt,":ClientID",$ClientID);
    oci_bind_by_name($stmt,":dietplan",$dietplan);

    $result = oci_execute($stmt);
    if(!$result){
        $e = oci_error($stmt);
        echo "Error: " . $e['message'];
    }

    oci_free_statement($stmt);
    oci_close($conn);

    header("Location: Nutritionist_View.php");
    exit;
    }

    // Free the statements and close the connection
   

?>
