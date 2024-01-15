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
    $filledFieldsCount = 0;
    foreach ($_POST as $key => $value) {
        if (!empty($value)) {
            $filledFieldsCount++;
        }
    }
    if ($filledFieldsCount == 0) {
        header("Location: warning.html");
    } else {
        $priceBasic1 = $_POST['priceBasic1'];
        $priceBasic6 = $_POST['priceBasic6'];
        $priceBasic12 = $_POST['priceBasic12'];

        $priceBasicPlus1 = $_POST['priceBasicPlus1'];
        $priceBasicPlus6 = $_POST['priceBasicPlus6'];
        $priceBasicPlus12 = $_POST['priceBasicPlus12'];

        $priceYogaNZumba1 = $_POST['priceYogaNZumba1'];
        $priceYogaNZumba6 = $_POST['priceYogaNZumba6'];
        $priceYogaNZumba12 = $_POST['priceYogaNZumba12'];

        $pricePremium1 = $_POST['pricePremium1'];
        $pricePremium6 = $_POST['pricePremium6'];
        $pricePremium12 = $_POST['pricePremium12'];

        $gymid = $_POST['GymID'];

        $stmt = array();
        $index = -1;

        if (!empty($priceBasic1)) {
            $index++;
            $query = "INSERT INTO OFFERS (PACKAGE_ID, GYM_ID, PRICE) VALUES ('P_1', :gymid, :priceBasic1)";
            $stmt[$index] = oci_parse($conn, $query);
            oci_bind_by_name($stmt[$index], ":gymid", $gymid);
            oci_bind_by_name($stmt[$index], ":priceBasic1", $priceBasic1);
        }
        if (!empty($priceBasic6)) {
            $index++;
            $query = "INSERT INTO OFFERS (PACKAGE_ID, GYM_ID, PRICE) VALUES ('P_2', :gymid, :priceBasic6)";
            $stmt[$index] = oci_parse($conn, $query);
            oci_bind_by_name($stmt[$index], ":gymid", $gymid);
            oci_bind_by_name($stmt[$index], ":priceBasic6", $priceBasic6);
        }
        if (!empty($priceBasic12)) {
            $index++;
            $query = "INSERT INTO OFFERS (PACKAGE_ID, GYM_ID, PRICE) VALUES ('P_3', :gymid, :priceBasic12)";
            $stmt[$index] = oci_parse($conn, $query);
            oci_bind_by_name($stmt[$index], ":gymid", $gymid);
            oci_bind_by_name($stmt[$index], ":priceBasic12", $priceBasic12);
        }
        if (!empty($priceBasicPlus1)) {
            $index++;
            $query = "INSERT INTO OFFERS (PACKAGE_ID, GYM_ID, PRICE) VALUES ('P_4', :gymid, :priceBasicPlus1)";
            $stmt[$index] = oci_parse($conn, $query);
            oci_bind_by_name($stmt[$index], ":gymid", $gymid);
            oci_bind_by_name($stmt[$index], ":priceBasicPlus1", $priceBasicPlus1);
        }
        if (!empty($priceBasicPlus6)) {
            $index++;
            $query = "INSERT INTO OFFERS (PACKAGE_ID, GYM_ID, PRICE) VALUES ('P_5', :gymid, :priceBasicPlus6)";
            $stmt[$index] = oci_parse($conn, $query);
            oci_bind_by_name($stmt[$index], ":gymid", $gymid);
            oci_bind_by_name($stmt[$index], ":priceBasicPlus6", $priceBasicPlus6);
        }
        if (!empty($priceBasicPlus12)) {
            $index++;
            $query = "INSERT INTO OFFERS (PACKAGE_ID, GYM_ID, PRICE) VALUES ('P_6', :gymid, :priceBasicPlus12)";
            $stmt[$index] = oci_parse($conn, $query);
            oci_bind_by_name($stmt[$index], ":gymid", $gymid);
            oci_bind_by_name($stmt[$index], ":priceBasicPlus12", $priceBasicPlus12);
        }
        if (!empty($priceYogaNZumba1)) {
            $index++;
            $query = "INSERT INTO OFFERS (PACKAGE_ID, GYM_ID, PRICE) VALUES ('P_7', :gymid, :priceYogaNZumba1)";
            $stmt[$index] = oci_parse($conn, $query);
            oci_bind_by_name($stmt[$index], ":gymid", $gymid);
            oci_bind_by_name($stmt[$index], ":priceYogaNZumba1", $priceYogaNZumba1);
        }
        if (!empty($priceYogaNZumba6)) {
            $index++;
            $query = "INSERT INTO OFFERS (PACKAGE_ID, GYM_ID, PRICE) VALUES ('P_8', :gymid, :priceYogaNZumba6)";
            $stmt[$index] = oci_parse($conn, $query);
            oci_bind_by_name($stmt[$index], ":gymid", $gymid);
            oci_bind_by_name($stmt[$index], ":priceYogaNZumba6", $priceYogaNZumba6);
        }
        if (!empty($priceYogaNZumba12)) {
            $index++;
            $query = "INSERT INTO OFFERS (PACKAGE_ID, GYM_ID, PRICE) VALUES ('P_9', :gymid, :priceYogaNZumba12)";
            $stmt[$index] = oci_parse($conn, $query);
            oci_bind_by_name($stmt[$index], ":gymid", $gymid);
            oci_bind_by_name($stmt[$index], ":priceYogaNZumba12", $priceYogaNZumba12);
        }
        if (!empty($pricePremium1)) {
            $index++;
            $query = "INSERT INTO OFFERS (PACKAGE_ID, GYM_ID, PRICE) VALUES ('P_10', :gymid, :pricePremium1)";
            $stmt[$index] = oci_parse($conn, $query);
            oci_bind_by_name($stmt[$index], ":gymid", $gymid);
            oci_bind_by_name($stmt[$index], ":pricePremium1", $pricePremium1);
        }
        if (!empty($pricePremium6)) {
            $index++;
            $query = "INSERT INTO OFFERS (PACKAGE_ID, GYM_ID, PRICE) VALUES ('P_11', :gymid, :pricePremium6)";
            $stmt[$index] = oci_parse($conn, $query);
            oci_bind_by_name($stmt[$index], ":gymid", $gymid);
            oci_bind_by_name($stmt[$index], ":pricePremium6", $pricePremium6);
        }
        if (!empty($pricePremium12)) {
            $index++;
            $query = "INSERT INTO OFFERS (PACKAGE_ID, GYM_ID, PRICE) VALUES ('P_12', :gymid, :pricePremium12)";
            $stmt[$index] = oci_parse($conn, $query);
            oci_bind_by_name($stmt[$index], ":gymid", $gymid);
            oci_bind_by_name($stmt[$index], ":pricePremium12", $pricePremium12);
        }

        
        for($i=0 ; $i<$index; $i++)
        {
            $result = oci_execute($stmt[$i]);
            if(!$result){
                $m = oci_error($stmt[$i]);
                trigger_error('Could not execute statement: ' . $m['message'], E_USER_ERROR);
            }
        }

        oci_close($conn);
        header("Location: ThanksOwnerlast.html");
        exit;
    }
    }
?>
