<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION['employee_id']) || empty($_SESSION['employee_id'])) {
    header("location: login.php");
    exit;
}
?>

<html>
    
        <meta charset="UTF-8">
        <meta name="wievport" content="width=device, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

        <!-- Own CSS link -->
        <link rel="stylesheet" href="search.css">

        <title>Vestas Carpool</title>
    
    <body>
        <div class="container-fluid">
            <a href="createRide.php" class="btn btn-default">Create Ride</a>
            <a href="myAccount.php" class="btn btn-default">My Account</a>
            <a href="logout.php" class="btn btn-default">Log out</a>
        </div>
        
        <!--search header -->
<div id="header">
    <div class="container container-header">
        <h3 class="header-text text-center">
            Find a ride!
        </h3>
        <div class="row">
            <div class="col-md-12 col-md-offset-3 text-center">

                <form class="my-2 my-lg-0" action="searchResult.php" method="get">

                    <input class="form-control search-bar" type="text" 
                           name="from" placeholder="Where do you travel from?"/>

                    <input class="form-control search-bar" type="text" 
                           name="to" placeholder="Where do you want to go?"/>

                    <div class="input-group search-bar date" id="datetimepicker4" data-target-input="nearest">
                        <input type="text" name="date" class="form-control datetimepicker-input" data-target="#datetimepicker4" placeholder="When do you want to travel?"/>
                        <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                        </div>
                    </div>


                    <input class="btn" type="submit" name="form_submit" value="Search" />

                </form>
            </div>


        </div>
    </div>
</div>
    </body>
</html>