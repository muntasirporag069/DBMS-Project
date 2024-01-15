<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer View</title>
    <link rel="stylesheet" type="text/css" href="Trainer_View.css">
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
        //Query to fetch info of current trainer 
        $query1 = "SELECT TRAINER_ID, TRAINER_NAME, GENDER, CONTACT_NO, EMAIL_ID, EXPERIENCE, SPECIALIZATION, GYM_ID FROM TRAINER WHERE TRAINER_ID = :ID";
        //Query to fetch info of clients of current trainer
        $query2 = "SELECT CLIENT_ID, CLIENT_NAME, AGE, GENDER, WEIGHT, SPECIAL_DISEASE, WHY FROM CLIENTS NATURAL JOIN RESULT WHERE TRAINER_ID = :ID";


        $stmt1 = oci_parse($conn,$query1);
        $stmt2 = oci_parse($conn,$query2);

        oci_bind_by_name($stmt1, ":ID", $ID);
        oci_bind_by_name($stmt2, ":ID", $ID);

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
        $client_data = array();
        while($row = oci_fetch_assoc($stmt2))
        {
            $client_data[] = $row;
        }
        oci_free_statement($stmt1);
        oci_free_statement($stmt2);
        oci_close($conn);
    ?>
    
    <header>
      
            <p class= "something "style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;font-size:xx-large" >
               Trainer View<br>
               
            </p>
   
        <br><br><br>
        <div class="LoCo">
            <p><b>Trainer ID: <?php echo $row1['TRAINER_ID']; ?></b></p><br>    
            <p><b>Trainer Name: <?php echo $row1['TRAINER_NAME']; ?></b></p><br>    
            <p><b>Gender: <?php echo $row1['GENDER']; ?></b></p><br>
            <p><b>Contact No: <?php echo $row1['CONTACT_NO']; ?></b></p><br>
            <p><b>Email Address: <?php echo $row1['EMAIL_ID']; ?></b></p><br>
            <p><b>Specialization: <?php echo $row1['SPECIALIZATION']; ?></b></p><br>
            <p><b>Experience: <?php echo $row1['EXPERIENCE']; ?></b></p><br>
            <p><b>Gym ID: <?php echo $row1['GYM_ID']; ?></b></p><br>
        </div><br>
        <p class="UpdateInfo"><a href="Update_Trainer.html"><b>Update your Basic Information</b></a></p>
        
        <br><br><br>


          <table>
            <caption class="caption1"><b>Clients</b></caption>
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Weight</th>
                <th>Disease</th>
                <th>Target</th>
                <th>Exercise Plan</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach ($client_data as $row): ?>
                    <tr>
                        <td><?php echo $row['CLIENT_ID']; ?></td>
                        <td><?php echo $row['CLIENT_NAME']; ?></td>
                        <td><?php echo $row['AGE']; ?></td>
                        <td><?php echo $row['GENDER']; ?></td>
                        <td><?php echo $row['WEIGHT']; ?></td>
                        <td><?php echo $row['SPECIAL_DISEASE']; ?></td>
                        <td><?php echo $row['WHY']; ?></td>
                        <td><ul class="horizontalbutton2">
                        <li><a href="ViewWorkoutPlan.php?client_id=<?php echo $row['CLIENT_ID']; ?>"><button>View</button></a></li>
                        <li><a href="EditWorkoutPlan.html"><button>Edit</button></a></li>
                        </ul></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
          </table>
          
          <br><br>
          <p style="color:black; text-align:center">          
                    <a href="login.html">Logout</a>
                   </p>
    
</body>
</html>