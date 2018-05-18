<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['employee_id']) || empty($_SESSION['employee_id'])){
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
            <a href="myRides.php" class="btn btn-default">View my offered rides.</a>
            <a href="myBookings.php" class="btn btn-default">View rides I've booked.</a>
            <a href="myAccount.php" class="btn btn-default">Edit account details.</a>
            <a href="index.php" class="btn btn-default">Back to front page</a>
        </div>
    </body>
</html>