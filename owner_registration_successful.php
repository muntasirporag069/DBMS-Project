<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Registration Successful</title>
  <link rel="stylesheet" type="text/css" href="registration_success.css">
  <script>
    setTimeout(function() {
      window.location.href = 'gym-registration.html';
    }, 5000); // Redirect after 5 seconds (5000 milliseconds)
  </script>
</head>
<body>
  <div class="container">
    <h1> Registration Successful! </h1><br><br>
    <p>Thank you for registering!</p><br>
    <p>Your ID is: <?php echo $_GET['id']; ?></p><br> <!-- Display the ID -->
    <p>You can now enjoy all the benefits of SNPNS community.</p><br>
    <p class="fitness">Stay Fit with us</p>
  </div>
</body>
</html>
