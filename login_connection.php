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
        $ID = $_POST['userID'];
        $password = $_POST['password'];

        $usertype = $_POST['usertype'];

        if($usertype == 'owner'){
            $query1 = "SELECT LOGIN_ID, PASSWORD, LOWER(TYPE) FROM LOG_IN WHERE LOGIN_ID = :ID";
            $query2 = "SELECT GYM_ID FROM OWN WHERE OWNER_ID = :ID";

            $stmt1 = oci_parse($conn,$query1);
            $stmt2 = oci_parse($conn,$query2);

            oci_bind_by_name($stmt1,":ID",$ID);
            oci_bind_by_name($stmt2,":ID",$ID);

            $result1 = oci_execute($stmt1);
            $result2 = oci_execute($stmt2);

            if(!$result1){
                $m = oci_error($stmt1);
                trigger_error('Could not execute statement: ' . $m['message'], E_USER_ERROR);
            }
            if(!$result2){
                $m = oci_error($stmt2);
                trigger_error('Could not execute statement: ' . $m['message'], E_USER_ERROR);
            }

            $row1 = oci_fetch_assoc($stmt1);
            $row2 = oci_fetch_assoc($stmt2);

            $SavedID = $row1['LOGIN_ID'];
            $SavedPassword = $row1['PASSWORD'];
            $SavedUsertype = $row1['LOWER(TYPE)'];

            $GYMID = $row2['GYM_ID'];
            oci_close($conn);

            if(($SavedID == $ID) && ($SavedPassword == $password) && ($SavedUsertype == $usertype)){
                $_SESSION['Current_User_ID'] = $ID;
                header("Location: Owner_View.php");
                exit;
            }
            else{
                echo "Incorrect Credentials";
            }
        }
        elseif($usertype == 'client'){
            $query = "SELECT LOGIN_ID, PASSWORD, LOWER(TYPE) FROM LOG_IN WHERE LOGIN_ID = :ID";

            $stmt = oci_parse($conn,$query);
            oci_bind_by_name($stmt,":ID",$ID);
            $result = oci_execute($stmt);
            if(!$result){
                $e = oci_error($stmt);
                echo "Error: " . $e['message'];
            }

            $row = oci_fetch_assoc($stmt);

            $SavedID = $row['LOGIN_ID'];
            $SavedPassword = $row['PASSWORD'];
            $SavedUsertype = $row['LOWER(TYPE)'];

            oci_close($conn);

            if(($SavedID == $ID) && ($SavedPassword == $password) && ($SavedUsertype == $usertype)){
                $_SESSION['Current_User_ID']=$ID;
                header("Location: Client_JustAfterLogin.html");
                exit;
            }
            else{
                echo "Incorrect Credentials";
            }
        }
        elseif($usertype == 'trainer'){
            $query = "SELECT LOGIN_ID, PASSWORD, LOWER(TYPE) FROM LOG_IN WHERE LOGIN_ID = :ID";

            $stmt = oci_parse($conn,$query);
            oci_bind_by_name($stmt,":ID",$ID);
            $result = oci_execute($stmt);

            $row = oci_fetch_assoc($stmt);

            $SavedID = $row['LOGIN_ID'];
            $SavedPassword = $row['PASSWORD'];
            $SavedUsertype = $row['LOWER(TYPE)'];

            oci_close($conn);

            if(($SavedID == $ID) && ($SavedPassword == $password) && ($SavedUsertype == $usertype)){
                $_SESSION['Current_User_ID'] = $ID;
                header("Location: Trainer_View.php");
                exit;
            }
            else{
                echo "Incorrect Credentials";
            }
        }
        elseif($usertype == 'nutritionist'){
            $query = "SELECT LOGIN_ID, PASSWORD, LOWER(TYPE) FROM LOG_IN WHERE LOGIN_ID = :ID";

            $stmt = oci_parse($conn,$query);
            oci_bind_by_name($stmt,":ID",$ID);
            $result = oci_execute($stmt);

            $row = oci_fetch_assoc($stmt);

            $SavedID = $row['LOGIN_ID'];
            $SavedPassword = $row['PASSWORD'];
            $SavedUsertype = $row['LOWER(TYPE)'];

            oci_close($conn);

            if(($SavedID == $ID) && ($SavedPassword == $password) && ($SavedUsertype == $usertype)){
                $_SESSION['Current_User_ID'] = $ID;
                header("Location: Nutritionist_View.php");
                exit;
            }
            else{
                echo "Incorrect Credentials";
            }
        }
    }
?>
