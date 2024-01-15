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
    $description = $_POST['target'];
    $duration = $_POST['duration'];

    $trainerID = $_SESSION['Current_User_ID'];

    // Prepare the SQL queries
    $query1 = "INSERT INTO TARGET (TARGET_ID, DURATION, DESCRIPTION) VALUES (GENERATETARGETID(), :duration, :description) RETURNING TARGET_ID INTO :targetID";
    $query2 = "INSERT INTO RESULT (CLIENT_ID, TARGET_ID, TRAINER_ID) VALUES (:ClientID, :targetID, :trainerID)";

    // Create a statement for query1
    $stmt1 = oci_parse($conn, $query1);

    // Bind the parameters for query1
    oci_bind_by_name($stmt1, ":duration", $duration);
    oci_bind_by_name($stmt1, ":description", $description);
    oci_bind_by_name($stmt1, ":targetID", $targetID, 32); // Assuming TARGET_ID is of VARCHAR2 type

    // Define the targetID variable
    oci_define_by_name($stmt1, ":duration", $duration);
    oci_define_by_name($stmt1, ":description", $description);
    oci_define_by_name($stmt1, ":targetID", $targetID);

    // Execute the first statement
    $result1 = oci_execute($stmt1);
    if (!$result1) {
        // $e = oci_error($stmt1);
        // echo "Error: " . $e['message'];
        header("Location: Trainer_View.php");
        exit;
    } else {
        // Fetch the result of the first statement
        // oci_fetch($stmt1);

        // Create a statement for query2
        $stmt2 = oci_parse($conn, $query2);

        // Bind the parameters for query2
        oci_bind_by_name($stmt2, ":ClientID", $ClientID);
        oci_bind_by_name($stmt2, ":targetID", $targetID);
        oci_bind_by_name($stmt2, ":trainerID", $trainerID);

        // Execute the second statement
        $result2 = oci_execute($stmt2);
        if (!$result2) {
            // $e = oci_error($stmt2);
            // echo "Error: " . $e['message'];
            header("Location: Trainer_View.php");
            exit;
        }
        header("Location: Trainer_View.php");
        exit;
    }

    // Free the statements and close the connection
    oci_free_statement($stmt1);
    oci_free_statement($stmt2);
    oci_close($conn);
}
?>
