<!DOCTYPE html>
<html>
<head>
  <title>View Diet Plan of Client</title>
  <link rel="stylesheet" type="text/css" href="ViewWorkOutPlan.css">
  <meta charset="UTF-8">
</head>
<body>
    <?php 
        
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
        $clientID = $_GET['client_id'];
        $query = "SELECT CLIENT_NAME, DIET_PLAN FROM PLANS NATURAL JOIN CLIENTS WHERE CLIENT_ID = :clientID";

        $stmt = oci_parse($conn,$query);
        oci_bind_by_name($stmt,":clientID",$clientID);

        $result = oci_execute($stmt);

        $row = oci_fetch_assoc($stmt);

        $clientName = $row['CLIENT_NAME'];
        $dietPlan = $row['DIET_PLAN'];

    ?> 
    <br><br><br><br><br><br><br><br>
    <ul>
        <div class="IDcontainer"><br>
            <ul class="ViewClient">
                <li><b>Client ID: <?php echo $_GET['client_id']; ?></b></li><br>
                <li><b>Client Name: <?php echo $clientName; ?></b></li>
            </ul>
        </div>
        <br>
        <div class="container">
            <div class="box1">
                <p class="disgusting"><b><b>Diet Plan</b></b></p><br><br><br><br>
                <p>
                    <?php echo $dietPlan;?>
                </p>
            </div>
        </div>
    </ul>

    <br>
    
</body>
</html>
