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
    $Trdmills = $_POST['Trdmills'];
    $Ellipticals = $_POST['Ellipticals'];
    $Stair = $_POST['Stair'];
    $Exercise = $_POST['Exercise'];
    $benchpress = $_POST['benchpress'];
    $rowingmachine = $_POST['rowingmachine'];
    $smithmachine = $_POST['smithmachine'];

    $gymid = $_POST['GymID'];

    if ($Trdmills == 'Yes') {
        $Amnt = $_POST['AmntTrdmills'];
        $query = "INSERT INTO ACQUIRES VALUES (:gymid, 'E_1' ,:Amnt, 'OK')";
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ":gymid", $gymid);
        oci_bind_by_name($stmt, ":Amnt", $Amnt);
        $result = oci_execute($stmt);
        if (!$result) {
            $e = oci_error($stmt);
            echo "Error: " . $e['message'];
        } else {
            oci_free_statement($stmt);
        }
    }
    if ($Ellipticals == 'Yes') {
        $Amnt = $_POST['AmntEllipticals'];
        $query = "INSERT INTO ACQUIRES VALUES (:gymid, 'E_2', :Amnt, 'OK')";
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ":gymid", $gymid);
        oci_bind_by_name($stmt, ":Amnt", $Amnt);
        $result = oci_execute($stmt);
        if (!$result) {
            $e = oci_error($stmt);
            echo "Error: " . $e['message'];
        } else {
            oci_free_statement($stmt);
        }
    }
    if ($Stair == 'Yes') {
        $Amnt = $_POST['AmntStrclmbr'];
        $query = "INSERT INTO ACQUIRES VALUES (:gymid, 'E_3', :Amnt, 'OK')";
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ":gymid", $gymid);
        oci_bind_by_name($stmt, ":Amnt", $Amnt);
        $result = oci_execute($stmt);
        if (!$result) {
            $e = oci_error($stmt);
            echo "Error: " . $e['message'];
        } else {
            oci_free_statement($stmt);
        }
    }
    if ($Exercise == 'Yes') {
        $Amnt = $_POST['AmntEB'];
        $query = "INSERT INTO ACQUIRES VALUES (:gymid, 'E_4', :Amnt, 'OK')";
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ":gymid", $gymid);
        oci_bind_by_name($stmt, ":Amnt", $Amnt);
        $result = oci_execute($stmt);
        if (!$result) {
            $e = oci_error($stmt);
            echo "Error: " . $e['message'];
        } else {
            oci_free_statement($stmt);
        }
    }
    if ($benchpress == 'Yes') {
        $Amnt = $_POST['AmntBP'];
        $query = "INSERT INTO ACQUIRES VALUES (:gymid, 'E_5',:Amnt, 'OK')";
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ":gymid", $gymid);
        oci_bind_by_name($stmt, ":Amnt", $Amnt);
        $result = oci_execute($stmt);
        if (!$result) {
            $e = oci_error($stmt);
            echo "Error: " . $e['message'];
        } else {
            oci_free_statement($stmt);
        }
    }
    if ($rowingmachine == 'Yes') {
        $Amnt = $_POST['AmntRM'];
        $query = "INSERT INTO ACQUIRES VALUES (:gymid, 'E_6', :Amnt, 'OK')";
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ":gymid", $gymid);
        oci_bind_by_name($stmt, ":Amnt", $Amnt);
        $result = oci_execute($stmt);
        if (!$result) {
            $e = oci_error($stmt);
            echo "Error: " . $e['message'];
        } else {
            oci_free_statement($stmt);
        }
    }
    if ($smithmachine == 'Yes') {
        $Amnt = $_POST['AmntSM'];
        $query = "INSERT INTO ACQUIRES VALUES (:gymid, 'E_7', :Amnt, 'OK')";
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ":gymid", $gymid);
        oci_bind_by_name($stmt, ":Amnt", $Amnt);
        $result = oci_execute($stmt);
        if (!$result) {
            $e = oci_error($stmt);
            echo "Error: " . $e['message'];
        } else {
            oci_free_statement($stmt);
        }
    }

    oci_close($conn);

    header("Location: formPackage.html");
    exit;
}
?>
