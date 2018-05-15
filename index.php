<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['email']) || empty($_SESSION['email'])){
  header("location: login.php");
  exit;
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <title>Vestas Carpool</title>
    </head>
    <body>
        <div class="container-fluid">
            <a href="createRide.php" class="btn btn-default">Create Ride</a>
            <a href="createUser.php" class="btn btn-default">Create User</a>
            <a href="index.php" class="btn btn-default">Log out</a>
        </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
