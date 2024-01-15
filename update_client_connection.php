<?php
// Database configuration
session_start();
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

    $newcontact = $_POST['contact'];
    $email = $_POST['email'];
    $emergencyContact = $_POST['emergencycontact'];
    $weight = $_POST['currentweight'];
    $disease=$_POST['disease'];

    $id = $_SESSION['Current_User_ID'];
    // Prepare the SQL query
    $query = "UPDATE CLIENTS
    SET CONTACT_NO=:newcontact, CLIENT_EMAIL=:email, EMERGENCY_CONTACT=:emergencyContact,WEIGHT=:weight,SPECIAL_DISEASE=:disease
    WHERE CLIENT_ID=:id";

    // Create a statement
    $stmt = oci_parse($conn, $query);

    // Bind the parameters
    oci_bind_by_name($stmt, ":newcontact", $newcontact);
    oci_bind_by_name($stmt, ":email", $email);
    oci_bind_by_name($stmt, ":emergencyContact", $emergencyContact);
    oci_bind_by_name($stmt, ":weight",$weight);
    oci_bind_by_name($stmt, ":disease",$disease);
    oci_bind_by_name($stmt, ":id", $id);

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
