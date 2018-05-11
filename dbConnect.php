<?php
define('DB_SERVER', 'server13.chosting.dk');
define('DB_USERNAME', 'dingode1');
define('DB_PASSWORD', 'xx');
define('DB_NAME', 'dingode1_carpool');
 
/* Connect to DB */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check if connection works
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>