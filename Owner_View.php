<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generic Gym Page for Owner</title>
    <link rel="stylesheet" type="text/css" href="Owner_View.css">
</head>
<body>
    
    <header>
    <?php
        session_start();
        $OWNERID = $_SESSION['Current_User_ID'];


        $host = "localhost/XE";
        $username = "DBMS";
        $password = "123";

        $connection = oci_connect($username, $password, $host);
        if(!$connection){
            $error = oci_error();
            die("Connection failed : ". $error['message']);
        }
            //                    SUBQUERIES
            //Query to find clients under this gym
            $query_client = "SELECT CLIENT_ID, CLIENT_NAME, PAYMENT_STATUS, PACKAGE_NAME 
            FROM PACKAGE NATURAL JOIN CHOOSE NATURAL JOIN CLIENTS
            WHERE GYM_ID = (SELECT GYM_ID FROM OWN WHERE OWNER_ID = :OWNERID)";
            //Query to find equipments available at this gym
            $query_equipment = "SELECT EQUIPMENT_ID, EQUIPMENT_NAME, AMOUNT, STATUS FROM EQUIPMENT NATURAL JOIN ACQUIRES NATURAL JOIN GYM WHERE GYM_ID = (SELECT GYM_ID FROM OWN WHERE OWNER_ID = :OWNERID)";
            //Query to find trainers hired at this gym
            $query_trainer = "SELECT TRAINER_ID, TRAINER_NAME, CONTACT_NO, EMAIL_ID, Gender, Experience  FROM Trainer WHERE GYM_ID = (SELECT GYM_ID FROM OWN WHERE OWNER_ID = :OWNERID)";
            //Query to find nutritionist hired at this gym
            $query_nutritionist = "SELECT NUTRITIONIST_ID, NUTRITIONIST_NAME, CONTACT_NO, EMAIL_ID, QUALIFICATION FROM NUTRITIONIST WHERE GYM_ID = (SELECT GYM_ID FROM OWN WHERE OWNER_ID = :OWNERID)";
            //Query to find packages offered at this gym
            $query_package = "SELECT PACKAGE_ID, PACKAGE_NAME, DURATION, PRICE FROM PACKAGE NATURAL JOIN OFFERS NATURAL JOIN GYM WHERE GYM_ID = (SELECT GYM_ID FROM OWN WHERE OWNER_ID = :OWNERID)";
            //Query to fetch name of the gym
            $query_gym="SELECT GYM_NAME FROM GYM WHERE GYM_ID=(SELECT GYM_ID FROM OWN WHERE OWNER_ID = :OWNERID)";

            $statement_client = oci_parse($connection,$query_client);
            $statement_equipment = oci_parse($connection,$query_equipment); 
            $statement_trainer = oci_parse($connection,$query_trainer);
            $statement_nutritionist = oci_parse($connection,$query_nutritionist);
            $statement_package = oci_parse($connection,$query_package);
            $statement_gym = oci_parse($connection,$query_gym);

            oci_bind_by_name($statement_client,":OWNERID",$OWNERID); 
            oci_bind_by_name($statement_equipment, ":OWNERID", $OWNERID);
            oci_bind_by_name($statement_trainer, ":OWNERID", $OWNERID);
            oci_bind_by_name($statement_nutritionist, ":OWNERID", $OWNERID);
            oci_bind_by_name($statement_package, ":OWNERID", $OWNERID);
            oci_bind_by_name($statement_gym, ":OWNERID", $OWNERID);

            $result_client = oci_execute($statement_client);
            $result_equipment = oci_execute($statement_equipment);
            $result_trainer = oci_execute($statement_trainer);
            $result_nutritionist = oci_execute($statement_nutritionist);
            $result_package = oci_execute($statement_package);
            $result_gym = oci_execute($statement_gym);

            if(!$result_client){
                $error = oci_error($statement_client);
                die("Query execution failed: " . $error['message']);
            }
            if(!$result_equipment){
                $error = oci_error($statement_equipment);
                die("Query execution failed: " . $error['message']);
            }
            if(!$result_nutritionist){
                $error = oci_error($statement_nutritionist);
                die("Query execution failed: " . $error['message']);
            }
            if(!$result_trainer){
                $error = oci_error($statement_trainer);
                die("Query execution failed: " . $error['message']);   
            }
            if(!$result_package){
                $error = oci_error($statement_package);
                die("Query execution failed: " . $error['message']);
            }
            if(!$result_gym){
                $error = oci_error($statement_gym);
                die("Query execution failed: " . $error['message']);
            }

            $client_data = array();
            $equipment_data = array();
            $trainer_data = array();
            $nutritionist_data = array();
            $package_data = array();

            while($client_row = oci_fetch_assoc($statement_client))
            {
                $client_data[] = $client_row;
            }
            while($equipment_row = oci_fetch_assoc($statement_equipment))
            {
                $equipment_data[] = $equipment_row;
            }
            while($trainer_row = oci_fetch_assoc($statement_trainer))
            {
                $trainer_data[] = $trainer_row;
            }
            while($nutritionist_row = oci_fetch_assoc($statement_nutritionist))
            {
                $nutritionist_data[] = $nutritionist_row;
            }
            while($package_row = oci_fetch_assoc($statement_package))
            {
                $package_data[] = $package_row;
            }

            $gym_row = oci_fetch_assoc($statement_gym);
            $gymname = $gym_row['GYM_NAME'];

            oci_free_statement($statement_client);
            oci_free_statement($statement_equipment);
            oci_free_statement($statement_trainer);
            oci_free_statement($statement_nutritionist);
            oci_free_statement($statement_package);
            oci_free_statement($statement_gym);
            oci_close($connection);
        
    ?>
            <p class= "something "style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;font-size:xx-large" >
               The Name of Gym: <?php echo $gymname; ?><br>
               
            </p>
   
        <br><br><br>
        <br><br><br>

        <table>
          <caption class="caption5"><b>Clients</b></caption>
          <thead>
            <tr>
              <th>Client ID</th>
              <th>Client Name</th>
              <th>Payment Status</th>
              <th>Package Name</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($client_data as $c_row): ?>
                <tr>
                    <td><?php echo $c_row['CLIENT_ID']; ?></td>
                    <td><?php echo $c_row['CLIENT_NAME']; ?></td>
                    <td><?php echo $c_row['PAYMENT_STATUS']; ?></td>
                    <td><?php echo $c_row['PACKAGE_NAME']; ?></td>
                </tr>
            <?php endforeach; ?>
            
          </tbody>
        </table>
<ul class="horizontal-list-1">
    <li><a href="Owner_Update_Client.html"><button><b>Update Client</b></button></a></li>
    <li><a href="delete_client_record.html"><button><b>Remove Client</b></button></a></li>
</ul>
       


          <table>
            <caption class="caption1"><b>Equipments</b></caption>
            <thead>
              <tr>
                <th>Equipment ID</th>
                <th>Equipment Name</th>
                <th>Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($equipment_data as $e_row): ?>
                <tr>
                    <td><?php echo $e_row['EQUIPMENT_ID']; ?></td>
                    <td><?php echo $e_row['EQUIPMENT_NAME']; ?></td>
                    <td><?php echo $e_row['AMOUNT']; ?></td>
                    <td><?php echo $e_row['STATUS']; ?></td>
                </tr>
            <?php endforeach; ?>
              
            </tbody>
          </table>
          <ul class="horizontal-list-2">
            <li> <a href="Update_Equipments.html"><button><b>Update Equipments</b></button></a></li>
            <li><a href="Delete_Equipments.html"><button><b>Remove Equipments</b></button></a></li>
        </ul><br><br>
         
        
          <table>
            <caption class="caption2"><b>Trainers</b></caption>
            <thead>
              <tr>
                <th>Trainer ID</th>
                <th>Trainer Name</th>
                <th>Contact No</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Experience</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($trainer_data as $t_row): ?>
                <tr>
                    <td><?php echo $t_row['TRAINER_ID']; ?></td>
                    <td><?php echo $t_row['TRAINER_NAME']; ?></td>
                    <td><?php echo $t_row['CONTACT_NO']; ?></td>
                    <td><?php echo $t_row['EMAIL_ID']; ?></td>
                    <td><?php echo $t_row['GENDER']; ?></td>
                    <td><?php echo $t_row['EXPERIENCE']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
          
          <ul class="horizontal-list-3">
            <li> <a href="Assign_Trainer_for_Client.html"><button><b>Assign Trainer</b></button></a></li>
            <li><a href="Request_Delete_Trainer.html"><button><b>Remove Trainer</b></button></a></li>
        </ul><br><br>

         
          <table>
            <caption class="caption3"><b>Nutritionists</b></caption>
            <thead>
              <tr>
                <th>Nutritionist ID</th>
                <th>Nutritionist Name</th>
                <th>Contact No</th>
                <th>Email ID</th>
                <th>Qualification</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($nutritionist_data as $n_row): ?>
                <tr>
                    <td><?php echo $n_row['NUTRITIONIST_ID']; ?></td>
                    <td><?php echo $n_row['NUTRITIONIST_NAME']; ?></td>
                    <td><?php echo $n_row['CONTACT_NO']; ?></td>
                    <td><?php echo $n_row['EMAIL_ID']; ?></td>
                    <td><?php echo $n_row['QUALIFICATION']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
          </table>

          <ul class="horizontal-list-4">
            <li><a href="Assign_Nutritionist_for_Client.html"><button><b>Assign Nutritionists</b></button></a></li>
            <li><a href="Request_Delete_Nutritionist.html"><button><b>Remove Nutritionists</b></button></a></li>
        </ul>




          <table>
            <caption class="caption4"><b>Packages</b></caption>
            <thead>
              <tr>
                <th>Package ID</th>
                <th>Package Name</th>
                <th>Duration</th>
                <th>Price</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($package_data as $p_row): ?>
              <tr>
                <td><?php echo $p_row['PACKAGE_ID']; ?></td>
                <td><?php echo $p_row['PACKAGE_NAME']; ?></td>
                <td><?php echo $p_row['DURATION']; ?></td>
                <td><?php echo $p_row['PRICE']; ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>

          <ul class="horizontal-list-5">
            <li><a href="Owner_Update_Packages.html"><button><b>Update Packages</b></button></a></li>
            <li><a href="delete_packages.html"><button><b>Remove Packages</b></button></a></li>
        </ul>
         
          <br><br>
          <p style="color:black; text-align:center">          
                    <a href="login.html">Logout</a>
                   </p>

</body>
</html>