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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $equipmentid = $_POST['equipmentid'];
    $status = $_POST['status'];
    $amount = $_POST['amount'];
    
    // Prepare the SQL query
    $query = "UPDATE ACQUIRES
    SET  AMOUNT= :amount, STATUS=:status
    WHERE EQUIPMENT_ID = :equipmentid";

    // Create a statement
    $stmt = oci_parse($conn, $query);

    // Bind the parameters
    oci_bind_by_name($stmt, ":equipmentid", $equipmentid);
    oci_bind_by_name($stmt, ":status", $status);
    oci_bind_by_name($stmt, ":amount", $amount);

    // Execute the statement
    $result = oci_execute($stmt);

    if ($result) {
        header("Location: update_successful.html");
        exit;
    } else {
        $e = oci_error($stmt);
        echo "Error: " . $e['message'];
    }

    // Free the statement and close the connection
    oci_free_statement($stmt);
    oci_close($conn);
}
?>
