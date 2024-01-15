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
    $ClientID = $_POST['ClientID'];
    $trainerID = $_POST['trainerID'];

    // Prepare the SQL query to insert into PLANS table
    $query = "INSERT INTO RESULT(CLIENT_ID, TRAINER_ID) VALUES (:ClientID, :trainerID)";

    // Create a statement
    $stmt = oci_parse($conn, $query);

    // Bind the parameters
    oci_bind_by_name($stmt, ":ClientID", $ClientID);
    oci_bind_by_name($stmt, ":trainerID", $trainerID);

    // Execute the statement
    $result = oci_execute($stmt);

    if ($result) {
        oci_commit($conn);
        oci_free_statement($stmt);
        oci_close($conn);

        // Redirect to success page
        header("Location: Owner_View.php");
        exit;
    } else {
        $e = oci_error($stmt);
        echo "Error inserting into RESULT table: " . $e['message'];
    }

    // Free the statement and close the connection
    oci_free_statement($stmt);
    oci_close($conn);
}
?>
