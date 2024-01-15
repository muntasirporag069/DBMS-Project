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
    $EquipID = $_POST['EquipID'];
    $Amount = $_POST['Amount'];
    $Status=$_POST['Status'];

    // Prepare the SQL query
    $query = "UPDATE ACQUIRES
    SET AMOUNT=:Amount,STATUS=:Status
    WHERE EQUIPMENT_ID=:EquipID";

    // Create a statement
    $stmt = oci_parse($conn, $query);

    // Bind the parameters
    oci_bind_by_name($stmt, ":EquipID", $EquipID);
    oci_bind_by_name($stmt, ":Amount", $Amount);
    oci_bind_by_name($stmt, ":Status",$Status);

    // Execute the statement
    $result = oci_execute($stmt);

    if ($result) {
        oci_commit($conn); // Commit the transaction to make the inserted data permanent

        // Free the statement and close the connection
        oci_free_statement($stmt);
        oci_close($conn);

        // Redirect to registration_success.html with the ID as a parameter
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
