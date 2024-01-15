<!DOCTYPE html>
<html>
<head>
  <title>View of Client</title>
  <link rel="stylesheet" type="text/css" href="Client_View.css">
  <meta charset="UTF-8">
  </head>
<body>
    <?php
        session_start();
        $ID = $_SESSION['Current_User_ID'];

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
        $query1 = "SELECT CLIENT_NAME, DOB, GENDER, WEIGHT, CONTACT_NO, EMERGENCY_CONTACT, CLIENT_EMAIL, WHY FROM CLIENTS WHERE CLIENT_ID = :ID";
        $query2 = "SELECT TRAINER_NAME, CONTACT_NO, WORKOUT_PLAN FROM TRAINER NATURAL JOIN RESULT WHERE CLIENT_ID = :ID"; 
        $query3 = "SELECT NUTRITIONIST_NAME, CONTACT_NO, DIET_PLAN FROM NUTRITIONIST NATURAL JOIN PLANS WHERE CLIENT_ID = :ID";

        $stmt1 = oci_parse($conn,$query1);
        $stmt2 = oci_parse($conn,$query2);
        $stmt3 = oci_parse($conn,$query3);

        oci_bind_by_name($stmt1, ":ID", $ID);
        oci_bind_by_name($stmt2, ":ID", $ID);
        oci_bind_by_name($stmt3, ":ID", $ID);

        $result1 = oci_execute($stmt1);
        $result2 = oci_execute($stmt2);
        $result3 = oci_execute($stmt3);

        if(!$result1){
            $m = oci_error($stmt1);
            trigger_error('Could not execute statement: ' . $m['message'], E_USER_ERROR);
        }
        if(!$result2){
            $m = oci_error($stmt2);
            trigger_error('Could not execute statement: ' . $m['message'], E_USER_ERROR);
        }
        if(!$result3){
            $m = oci_error($stmt3);
            trigger_error('Could not execute statement: ' . $m['message'], E_USER_ERROR);
        }

        $row1 = oci_fetch_assoc($stmt1);
        $row2 = oci_fetch_assoc($stmt2);
        $row3 = oci_fetch_assoc($stmt3);

        oci_free_statement($stmt1);
        oci_free_statement($stmt2);
        oci_free_statement($stmt3);
        oci_close($conn);

    ?>
    <br><br><br><br><br><br><br><br>
   <ul>
        
    <div class="IDcontainer">
        <p class="ViewClient">
          <b><b><b> Client View</b> </b></b> 
        </p>
    </div>
    <br>
<div class="container">
    <div class="box1">
        <p class="disgusting"><b><b>Basic Information</b></b></p>
      <p>
        
        <ul>
            <li><b><b>Name: <?php echo $row1['CLIENT_NAME']; ?></b></b></li><br>
            <li><b><b>Date of Birth: <?php echo $row1['DOB']; ?></b></b></li><br>
            <li><b><b>Gender: <?php echo $row1['GENDER']; ?></b></b></li><br>
            <li><b><b>Contact no: <?php echo $row1['CONTACT_NO']; ?></b></b></li><br>
            <li><b><b>Emergency Contact no: <?php echo $row1['EMERGENCY_CONTACT']; ?></b></b></li><br>
            <li><b><b>Email Address: <?php echo $row1['CLIENT_EMAIL']; ?></b></b></li><br>
            <li><b><b>Current Weight:<?php echo $row1['WEIGHT']; ?></b></b></li><br>
            <li><b><b>Goal: <?php echo $row1['WHY']; ?></b></b></li><br>

            <div class="UpdateInfo"><a href="update_client_information.html">Update Your Information</a></div>
            
            <p class="TextCurrentTN"><b><b>Trainer & Nutritionist:</b></b></p><br>
            <li><b><b>Current Trainer: <?php echo $row2['TRAINER_NAME']; ?></b></b></li><br>
            <li><b><b>Contact No: <?php echo $row2['CONTACT_NO']; ?></b></b></li><br>
            <li><b><b>Current Nutritionist: <?php echo $row3['NUTRITIONIST_NAME']; ?></b></b></li><br>
            <li><b><b>Contact No: <?php echo $row3['CONTACT_NO']; ?></b></b></li><br>
            <p class="textTarget"><b><b>Workout Plan:</b></b></p><br>
            <li><b><b>Current Routine: <?php echo $row2['WORKOUT_PLAN']; ?></b></b></li><br>
            <br>
            <p class="textTargetPlan"><b><b>Diet Plan:</b></b></p>
            <li><b><b>Current Plan: <?php echo $row3['DIET_PLAN']; ?></b></b></li><br>
         

        </ul>
    </p>
    </div>
</div>




   <br>
   <ul>
        <li class="retHome"><b><a href="Client_justAfterLogin.html">Return to Homepage</a></b></li>
    </ul>
   
   
</body>
</html>
