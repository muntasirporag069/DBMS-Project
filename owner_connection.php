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
    $name = $_POST['firstname'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    

    // Prepare the SQL query
    //Sequence
    $query = "INSERT INTO OWNER (OWNER_ID, OWNER_NAME, CONTACT_NO, EMAIL_ID) 
              VALUES (GENERATEOWNERID, :name, :contact, :email) 
              RETURNING OWNER_ID INTO :new_id";

    // Create a statement
    $stmt = oci_parse($conn, $query);

    // Bind the parameters
    oci_bind_by_name($stmt, ":name", $name);
    oci_bind_by_name($stmt, ":contact", $contact);
    oci_bind_by_name($stmt, ":email", $email);
    oci_bind_by_name($stmt, ":new_id", $new_id, 32);

    // Execute the statement
    $result = oci_execute($stmt);

    if ($result) {
        oci_commit($conn);

        // Fetch the generated OWNER_ID
        oci_fetch($stmt);
        $new_id = $new_id;

        $_SESSION['Owner_ID'] = $new_id;

        // Insert login credentials into LOG_IN table
        $loginQuery = "INSERT INTO LOG_IN (LOGIN_ID, PASSWORD, TYPE) 
                       VALUES (:new_id, :password, 'OWNER')";

        

        $loginStmt = oci_parse($conn, $loginQuery);

        oci_bind_by_name($loginStmt, ":new_id", $new_id);
        oci_bind_by_name($loginStmt, ":password", $password);

        $loginResult = oci_execute($loginStmt);

        if ($loginResult) {
            oci_commit($conn);
            oci_free_statement($loginStmt);
            oci_free_statement($stmt);
            oci_close($conn);

            // Redirect to owner_registration_successful.php with the ID as a parameter
            header("Location: owner_registration_successful.php?id=$new_id");
            exit;
        } else {
            $e = oci_error($loginStmt);
            echo "Error inserting into LOG_IN table: " . $e['message'];
        }
    } else {
        $e = oci_error($stmt);
        echo "Error inserting into OWNER table: " . $e['message'];
    }

    // Free the statement and close the connection
    oci_free_statement($stmt);
    oci_close($conn);
}
?>
