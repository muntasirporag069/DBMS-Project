<?php
// Database configuration
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data

    $nutritionistid = $_POST['nutritionistid'];
    $editfname = $_POST['editfname'];
    $editcontact = $_POST['editcontact'];
    $editemail = $_POST['editemail'];

    // Prepare the SQL query
    $query = "UPDATE NUTRITIONIST
    SET NUTRITIONIST_NAME=:editfname, CONTACT_NO=:editcontact, EMAIL_ID=:editemail WHERE NUTRITIONIST_ID = :nutritionistid";

    // Create a statement
    $stmt = oci_parse($conn, $query);

    // Bind the parameters
    oci_bind_by_name($stmt, ":nutritionistid", $nutritionistid);
    oci_bind_by_name($stmt, ":editfname", $editfname);
    oci_bind_by_name($stmt, ":editcontact", $editcontact);
    oci_bind_by_name($stmt, ":editemail",$editemail);

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
