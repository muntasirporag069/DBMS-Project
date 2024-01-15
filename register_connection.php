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
    $name = $_POST['firstname'];
    $gender = $_POST['gender'];
    $dob = $_POST['event-time'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $emergencyContact = $_POST['emergencycontact'];
    $weight = $_POST['currentweight'];
    $height = $_POST['yourheight'];
    $reason = $_POST['subject'];
    $password = $_POST['password'];

    
    $query = "INSERT INTO CLIENTS (CLIENT_ID, CLIENT_NAME, GENDER, DOB, CONTACT_NO, CLIENT_EMAIL, EMERGENCY_CONTACT, WEIGHT, SPECIAL_DISEASE, WHY) 
              VALUES (GENERATECLIENTID, :name, :gender, TO_DATE(:dob, 'YYYY-MM-DD\"T\"HH24:MI'), :contact, :email, :emergency_contact, :weight, :height, :reason) 
              RETURNING CLIENT_ID INTO :new_id";

    $stmt = oci_parse($conn, $query);

    
    oci_bind_by_name($stmt, ":name", $name);
    oci_bind_by_name($stmt, ":gender", $gender);
    oci_bind_by_name($stmt, ":dob", $dob);
    oci_bind_by_name($stmt, ":contact", $contact);
    oci_bind_by_name($stmt, ":email", $email);
    oci_bind_by_name($stmt, ":emergency_contact", $emergencyContact);
    oci_bind_by_name($stmt, ":weight", $weight);
    oci_bind_by_name($stmt, ":height", $height);
    oci_bind_by_name($stmt, ":reason", $reason);
    oci_bind_by_name($stmt, ":new_id", $newId, 32);

    $result = oci_execute($stmt);

    if ($result) {
        oci_commit($conn); // Commit the transaction to make the inserted data permanent

        $loginQuery = "INSERT INTO LOG_IN (LOGIN_ID, PASSWORD, TYPE) 
                       VALUES (:new_id, :password, 'CLIENT')";

        $loginStmt = oci_parse($conn, $loginQuery);

        oci_bind_by_name($loginStmt, ":new_id", $newId);
        oci_bind_by_name($loginStmt, ":password", $password);

        $loginResult = oci_execute($loginStmt);

        if ($loginResult) {
            oci_commit($conn); 

            oci_free_statement($loginStmt);
            oci_free_statement($stmt);
            oci_close($conn);

            header("Location: registration_success.php?id=$newId");
            exit;
        } else {
            $e = oci_error($loginStmt);
            echo "Error inserting into LOGIN table: " . $e['message'];
        }
        
        oci_free_statement($loginStmt);
    } 
    //                      EXCEPTION HANDLING AND TRIGGER
    //   CREATE OR REPLACE TRIGGER age_limit
    //   BEFORE INSERT
    //   ON CLIENTS
    //   FOR EACH ROW
    //   WHEN ( NEW.AGE < 18 )
    //   DECLARE
    //   AGE_ERROR EXCEPTION; BEGIN
    //   RAISE AGE_ERROR;
    //   EXCEPTION
    //   WHEN AGE_ERROR THEN
    //   RAISE_APPLICATION_ERROR(-20111,'AGE NOT ALLOWED' );
    //   END;
    else {
        $e = oci_error($stmt);
        if ($e['code'] === 20111) {
            header("Location: cant_register.html");
        }
    }
    
    
    oci_free_statement($stmt);
    oci_close($conn);
}
?>
