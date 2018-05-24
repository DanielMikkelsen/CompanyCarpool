<?php
$con = mysqli_connect("server13.chosting.dk","dingode1","xx","dingode1_carpool");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  mysqli_set_charset($con,"utf8");

?>