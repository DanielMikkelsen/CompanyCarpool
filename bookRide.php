<?php

// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION['employee_id']) || empty($_SESSION['employee_id'])) {
    header("location: login.php");
    exit;
}

require('dbConnectProcedural.php');

//employee to book the seat for
$employee_id = $_SESSION['employee_id'];

//the ride to book the seat in
$ride_id = $_REQUEST['id'];

$sql = "INSERT INTO Seat (employee_id, ride_id) VALUES ($employee_id, $ride_id)";
$result = mysqli_query($con, $sql) or die ( mysqli_error($con));

//Subtract one from available_seat in the Ride table when a seat is booked
$sql = "UPDATE Ride SET available_seats = available_seats - 1 WHERE ride_id = $ride_id";
$result = mysqli_query($con, $sql) or die ( mysqli_error($con));

// Close connection
mysqli_close($con);

header("Location: index.php");
?>