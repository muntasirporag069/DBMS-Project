<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generic Gym Page for Owner</title>
    <link rel="stylesheet" type="text/css" href="genericGymPage.css">
</head>
<body>
    <?php
      session_start();

      $host = "//localhost/XE";
      $username = "DBMS";
      $password = "123";

      // Establish a connection to the Oracle database
      $connection = oci_connect($username, $password, $host);
      if (!$connection) {
          $error = oci_error();
          die("Connection failed: " . $error['message']);
      }
      
      if(isset($_GET['id'])){
          $GYMID = $_GET['id'];
          $_SESSION['Current_Gym_ID'] = $GYMID;

          $query_equipment = "SELECT EQUIPMENT_NAME, AMOUNT, STATUS FROM EQUIPMENT NATURAL JOIN ACQUIRES WHERE GYM_ID = :GYMID";
          $query_trainer = "SELECT TRAINER_NAME, CONTACT_NO, EMAIL_ID, Gender, Experience  FROM Trainer WHERE GYM_ID = :GYMID";
          $query_nutritionist = "SELECT NUTRITIONIST_NAME, CONTACT_NO, EMAIL_ID, QUALIFICATION FROM NUTRITIONIST WHERE GYM_ID = :GYMID";
          $query_package = "SELECT PACKAGE_ID, PACKAGE_NAME, DURATION, PRICE FROM PACKAGE NATURAL JOIN OFFERS WHERE GYM_ID = :GYMID";
          $query_gym = "SELECT GYM_NAME, AREA, CONTACT_NO FROM GYM WHERE GYM_ID = :GYMID";

          $statement_equipment = oci_parse($connection,$query_equipment); 
          $statement_trainer = oci_parse($connection,$query_trainer);
          $statement_nutritionist = oci_parse($connection,$query_nutritionist);
          $statement_package = oci_parse($connection,$query_package);
          $statement_gym = oci_parse($connection,$query_gym);

          oci_bind_by_name($statement_equipment, ":GYMID", $GYMID);
          oci_bind_by_name($statement_trainer, ":GYMID", $GYMID);
          oci_bind_by_name($statement_nutritionist, ":GYMID", $GYMID);
          oci_bind_by_name($statement_package, ":GYMID", $GYMID);
          oci_bind_by_name($statement_gym, ":GYMID", $GYMID);

          $result_equipment = oci_execute($statement_equipment);
          $result_trainer = oci_execute($statement_trainer);
          $result_nutritionist = oci_execute($statement_nutritionist);
          $result_package = oci_execute($statement_package);
          $result_gym = oci_execute($statement_gym);
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

          $equipment_data = array();
          $trainer_data = array();
          $nutritionist_data = array();
          $package_data = array();

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
          $row = oci_fetch_assoc($statement_gym);
          $location = $row['AREA'];
          $contact = $row['CONTACT_NO'];
          $gymname = $row['GYM_NAME'];

          oci_free_statement($statement_equipment);
          oci_free_statement($statement_trainer);
          oci_free_statement($statement_nutritionist);
          oci_free_statement($statement_package);
          oci_free_statement($statement_gym);
          oci_close($connection);
        }
    ?>
    <header>
      
            

            <p class= "something "style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;font-size:xx-large" >
               The Name of Gym: <?php echo "$gymname"; ?><br>
               
            </p>
   
        <br><br><br>
        <div class="LoCo">
            <p><b><b>Location: <?php echo "$location"; ?></b></b></p><br>
            <p><b><b>Contact no: <?php echo "$contact"; ?></b></b></p><br>
        </div><br><br><br>
        
    


        <table>
            <caption class="caption1"><b>Equipments</b></caption>
            <thead>
              <tr>
                <th>Equipment Name</th>
                <th>Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($equipment_data as $e_row): ?>
                <tr>
                    <td><?php echo $e_row['EQUIPMENT_NAME']; ?></td>
                    <td><?php echo $e_row['AMOUNT']; ?></td>
                    <td><?php echo $e_row['STATUS']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table><br><br>
         
        
          <table>
            <caption class="caption2"><b>Trainers</b></caption>
            <thead>
              <tr>
                <th>Trainer Name</th>
                <th>Contact No</th>
                <th>Email ID</th>
                <th>Gender</th>
                <th>Experience</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($trainer_data as $t_row): ?>
                <tr>
                    <td><?php echo $t_row['TRAINER_NAME']; ?></td>
                    <td><?php echo $t_row['CONTACT_NO']; ?></td>
                    <td><?php echo $t_row['EMAIL_ID']; ?></td>
                    <td><?php echo $t_row['GENDER']; ?></td>
                    <td><?php echo $t_row['EXPERIENCE']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table><br><br>

         
          <table>
            <caption class="caption3"><b>Nutritionists</b></caption>
            <thead>
              <tr>
                <th>Nutritionist Name</th>
                <th>Contact No</th>
                <th>Email ID</th>
                <th>Qualification</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($nutritionist_data as $n_row): ?>
                <tr>
                    <td><?php echo $n_row['NUTRITIONIST_NAME']; ?></td>
                    <td><?php echo $n_row['CONTACT_NO']; ?></td>
                    <td><?php echo $n_row['EMAIL_ID']; ?></td>
                    <td><?php echo $n_row['QUALIFICATION']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>


          <table>
            <caption class="caption4"><b>Packages</b></caption>
            <thead>
              <tr>
                <th>Name</th>
                <th>Duration</th>
                <th>Price</th>
                <th>Subscription</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($package_data as $p_row): ?>
              <tr>
                <td><?php echo $p_row['PACKAGE_NAME']; ?></td>
                <td><?php echo $p_row['DURATION']; ?></td>
                <td><?php echo $p_row['PRICE']; ?></td>
                <td class="Subscribe">
                  <a href="buying_package.php?PACKAGE_ID=<?php echo $p_row['PACKAGE_ID']; ?>">
                    <button><b>Subscribe</b></button>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
          
          <br><br>

</body>
</html>