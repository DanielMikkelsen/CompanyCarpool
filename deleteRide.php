<?php
require('dbConnectProcedural.php');
$ride_id=$_REQUEST['id'];
$sql = "DELETE FROM Ride WHERE ride_id = $ride_id"; 
$result = mysqli_query($con,$sql) or die ( mysqli_error());

// Close connection
mysqli_close($con);

header("Location: myRides.php");
?>