<?php
require('dbConnectProcedural.php');
$ride_id=$_REQUEST['id'];
$query = "DELETE FROM Ride WHERE ride_id = $ride_id"; 
$result = mysqli_query($con,$query) or die ( mysqli_error());
header("Location: index.php"); 
?>