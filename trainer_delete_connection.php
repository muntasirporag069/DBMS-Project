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
    $TrainerID = $_POST['TrainerID'];

    // Prepare the SQL query
    $query = "Delete from TRAINER where TRAINER_ID=:TrainerID";

    // Create a statement
    $stmt = oci_parse($conn, $query);

    // Bind the parameters
    oci_bind_by_name($stmt, ":packageid", $packageid);
    
    // Execute the statement
    $result = oci_execute($stmt);

    if ($result) {
        header("Location: deletionSuccessful.html");
        // Redirect to view_data.php after 2 seconds
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
