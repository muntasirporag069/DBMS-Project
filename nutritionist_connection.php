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
    $nutritionistname = $_POST['firstname'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $qualification = $_POST['qlfctn'];
    $experience = $_POST['exp'];
    $gymID = $_POST['gym_id'];
    $password = $_POST['password'];

    // Generate a new NUTRITIONIST_ID using the database function
    $query = "BEGIN :newId := GENERATENUTRITIONISTID; END;";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":newId", $newId, 32);
    oci_execute($stmt);
    oci_free_statement($stmt);

    // Prepare the SQL query
    $query = "INSERT INTO NUTRITIONIST (NUTRITIONIST_ID, NUTRITIONIST_NAME, CONTACT_NO, EMAIL_ID, EXPERIENCE, QUALIFICATION, GYM_ID) VALUES (:newId, :nutritionistname, :contact, :email, :experience, :qualification, :gymID)
    returning NUTRITIONIST_ID INTO :new_id";

    // Create a statement
    $stmt = oci_parse($conn, $query);

    // Bind the parameters
    oci_bind_by_name($stmt, ":newId", $newId);
    oci_bind_by_name($stmt, ":nutritionistname", $nutritionistname);
    oci_bind_by_name($stmt, ":contact", $contact);
    oci_bind_by_name($stmt, ":email", $email);
    oci_bind_by_name($stmt, ":experience", $experience);
    oci_bind_by_name($stmt, ":qualification", $qualification);
    oci_bind_by_name($stmt, ":gymID", $gymID);
    oci_bind_by_name($stmt, ":new_id", $new_id, 32);

    // Execute the statement
    $result = oci_execute($stmt);

    if ($result) {
        oci_commit($conn);

        // Insert login credentials into LOG_IN table
        $loginQuery = "INSERT INTO LOG_IN (LOGIN_ID, PASSWORD, TYPE) 
                       VALUES (:new_id, :password, 'NUTRITIONIST')";
        
        $loginStmt = oci_parse($conn, $loginQuery);

        oci_bind_by_name($loginStmt, ":new_id", $new_id);
        oci_bind_by_name($loginStmt, ":password", $password);

        $loginResult = oci_execute($loginStmt);

        if ($loginResult) {
            oci_commit($conn);
            oci_free_statement($loginStmt);
            oci_free_statement($stmt);
            oci_close($conn);
            
            // Redirect to nutritionist_register_successful.php with the ID as a parameter
            header("Location: nutritionist_register_successful.php?id=$new_id");
            exit;
        } else {
            $e = oci_error($loginStmt);
            echo "Error inserting into LOG_IN table: " . $e['message'];
        }
    } else {
        $e = oci_error($stmt);
        echo "Error inserting into NUTRITIONIST table: " . $e['message'];
    }

    // Free the statement and close the connection
    oci_free_statement($stmt);
    oci_close($conn);
}
?>
