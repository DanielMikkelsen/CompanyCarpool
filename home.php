<?php
require_once 'dbConnectProcedural.php';

// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION['employee_id']) || empty($_SESSION['employee_id'])) {
    header("location: login.php");
    exit;
}

?>


<!doctype html>
<html lang="en" class="full-height">

    <head>
        <meta charset="utf-8">
        <title>Rides</title>
        <meta name="wievport" content="width=device, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

        <!-- Own CSS link -->
        <link rel="stylesheet" href="home.css">

    </head>
    <body>

    
        <!--navnbar -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="home.php"><strong>Vestas Carpool</strong></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Navbar: Left side-->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Find ride</a> <span class="sr-only">(current)</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="createRide.php">Offer Ride</a>
                        </li>
                    </ul>

                    <!-- Navbar: Right side-->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="myAccount.php">My Rides</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!--navnbar -->
     

        <!--Header-->
    <div id="header">
        <div class="container py-5 container-header">
            <div class="row justify-content-center align-self-center">
                    <div class="col col-sm-6">
                        <div class="card bg-transparent">
                            <div class="card-body">
                                <a class="nav-link" href="index.php">
                                <h3 class="card-title" >Find ride</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col col-sm-6">
                        <div class="card bg-transparent">
                            <div class="card-body">
                                <a class="nav-link" href="createRide.php">
                                <h3 class="card-title">Offer ride</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <!--Header-->
    

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    </body>
</html>

