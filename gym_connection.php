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
    $gymname = $_POST['firstname'];
    $division = $_POST['lctnGym'];
    $city = $_POST['city'];
    $area = $_POST['area'];
    $house = $_POST['house'];
    $contact = $_POST['contact'];
    $specialization = $_POST['subject'];

    // Get the next gym ID from the function
    $query = "BEGIN :gymId := GENERATEGYMID; END;";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":gymId", $gymId, 10);
    oci_execute($stmt);
    oci_free_statement($stmt);

    // Prepare the SQL query
    $query = "INSERT INTO GYM (GYM_ID, GYM_NAME, CONTACT_NO, SPECIALIZATION, CITY, DIVISION, AREA, HOUSE)
              VALUES (:gymId, :gymname, :contact, :specialization, :city, :division, :area, :house)
              RETURNING GYM_ID INTO :new_id";

    $ownerID = $_SESSION['Owner_ID'];
    $query2 = "INSERT INTO OWN(OWNER_ID,GYM_ID) VALUES(:ownerID,:gymId)";
    // Create a statement
    $stmt = oci_parse($conn, $query);
    $stmt2 = oci_parse($conn,$query2);
    // Bind the parameters
    oci_bind_by_name($stmt, ":gymId", $gymId);
    oci_bind_by_name($stmt, ":gymname", $gymname);
    oci_bind_by_name($stmt, ":contact", $contact);
    oci_bind_by_name($stmt, ":specialization", $specialization);
    oci_bind_by_name($stmt, ":city", $city);
    oci_bind_by_name($stmt, ":division", $division);
    oci_bind_by_name($stmt, ":area", $area);
    oci_bind_by_name($stmt, ":house", $house);
    oci_bind_by_name($stmt, ":new_id", $newId, 32);

    oci_bind_by_name($stmt2, ":ownerID", $ownerID);
    oci_bind_by_name($stmt2,":gymId",$gymId);

    // Execute the statement
    $result = oci_execute($stmt);
    $result2 = oci_execute($stmt2);
    if (!$result) {
        $e = oci_error($stmt);
        echo "Error: " . $e['message'];
    } elseif(!$result2){
        $e = oci_error($stmt2);
        echo "Error: " . $e['message'];
    } else {
        oci_free_statement($stmt);
        oci_free_statement($stmt2);
        oci_close($conn);

        // Redirect to confirmingGymOwner.php with the new gym ID
        header("Location: confirmingGymOwner.php?id=$newId");
        exit;
    }

    // Free the statement and close the connection
    oci_free_statement($stmt);
    oci_close($conn);
}
?>
