<!DOCTYPE html>
<html>
<head>
  <title>Registration Successful</title>
  <link rel="stylesheet" type="text/css" href="confirmingGymOwner.css">
  <meta charset="UTF-8">
</head>
<body>
  <div class="container">
    <div class="box1">
      <p>
        <h1>🎉 Registration Successful! 🎉</h1><br><br>
      <p>Thank you for registering!</p><br>
      <p>Your GYM ID is: <?php echo $_GET['id']; ?></p><br> <!-- Display the ID -->
      <p>Please add  offered packages and the available equipments in your gym</p><br><br>
      </p>
    </div>
   
  
    <br>
   <br><p  class="addEQPC"><b><a href="Equipments.html">Add Equipment and Packages</a></b></p>
   
</body>
</html>
