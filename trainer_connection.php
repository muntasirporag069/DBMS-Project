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
    $trainername = $_POST['firstname'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $specialized = $_POST['specialized'];
    $exp = $_POST['exp'];
    $gym_id = $_POST['gym_id'];
    $password = $_POST['password'];
    
    // Generate a new TRAINER_ID using the database function
    $query = "BEGIN :newId := GENERATETRAINERID; END;";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":newId", $newId, 32);
    oci_execute($stmt);
    oci_free_statement($stmt);

    // Prepare the SQL query
    $query = "INSERT INTO TRAINER (TRAINER_ID, TRAINER_NAME, CONTACT_NO, EMAIL_ID, GENDER, SPECIALIZATION, EXPERIENCE, GYM_ID) 
              VALUES (:newId, :trainername, :contact, :email, :gender, :specialized, :exp, :gym_id) 
              returning TRAINER_ID INTO :new_id";

    // Create a statement
    $stmt = oci_parse($conn, $query);

    // Bind the parameters
    oci_bind_by_name($stmt, ":newId", $newId);
    oci_bind_by_name($stmt, ":trainername", $trainername);
    oci_bind_by_name($stmt, ":contact", $contact);
    oci_bind_by_name($stmt, ":email", $email);
    oci_bind_by_name($stmt, ":gender", $gender);
    oci_bind_by_name($stmt, ":specialized", $specialized);
    oci_bind_by_name($stmt, ":exp", $exp);
    oci_bind_by_name($stmt, ":gym_id", $gym_id);
    oci_bind_by_name($stmt, ":new_id", $new_id, 32);

    // Execute the statement
    $result = oci_execute($stmt);

    if ($result) {
        oci_commit($conn);

        // Insert login credentials into LOG_IN table
        $loginQuery = "INSERT INTO LOG_IN (LOGIN_ID, PASSWORD, TYPE) 
                       VALUES (:new_id, :password, 'TRAINER')";
        
        $loginStmt = oci_parse($conn, $loginQuery);

        oci_bind_by_name($loginStmt, ":new_id", $new_id);
        oci_bind_by_name($loginStmt, ":password", $password);

        $loginResult = oci_execute($loginStmt);

        if ($loginResult) {
            oci_commit($conn);
            oci_free_statement($loginStmt);
            oci_free_statement($stmt);
            oci_close($conn);
            
            // Redirect to trainer_register_successful.php with the ID as a parameter
            header("Location: trainer_registration_successful.php?id=$new_id");
            exit;
        } else {
            $e = oci_error($loginStmt);
            echo "Error inserting into LOG_IN table: " . $e['message'];
        }
    } else {
        $e = oci_error($stmt);
        echo "Error inserting into TRAINER table: " . $e['message'];
    }

    // Free the statement and close the connection
    oci_free_statement($stmt);
    oci_close($conn);
}
?>
