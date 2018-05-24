<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION['employee_id']) || empty($_SESSION['employee_id'])) {
    header("location: login.php");
    exit;
}

// Include dbConnection file
require_once 'dbConnectProcedural.php';

//employee to book the ride for
$employee_id = $_SESSION['employee_id'];
?>

<!DOCTYPE html>
<html lang="en">

     <head>
        <title>Vestas Carpool: Search results</title>
        <meta name="wievport" content="width=device, initial-scale=1" charset="UTF-8">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">


        <!-- Own CSS link -->
        <link rel="stylesheet" href="myRides.css">

        <style type="text/css">
            .wrapper{
                width: 500px;
                margin: 0 auto;
            }
        </style>
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
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Find ride</a> 
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="createRide.php">Offer Ride</a>
                        </li>
                    </ul>
                <!-- Navbar: Right side-->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="myAccount.php">My Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
            <!--navnbar -->


       <div class="container container-calender">
                <h3 class="header-text text-center">
                My offered rides
                </h3>
                <?php
                    $sql = "Select * from Ride WHERE employee_id = '$employee_id'";
                    $result = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
            <div id="<?php echo $row['ride_id']; ?>" class="row row-striped event">
                <div class="col-2 text-right">
                    <h1><span class="badge badge-secondary"><?php echo date("d", strtotime($row['departure_date'])); ?></span></h1>
                    <h3><?php echo date("M", strtotime($row['departure_date'])); ?></h3>
                </div>
                <div class="col-10">
                        <h4 class="text-uppercase"><strong><?php echo $row['depart_city']; ?> - <?php echo $row['dest_city']; ?></strong>
                            <li class="list-inline-item pull-right">
                            </li>    
                        </h4>
                    <div class="row">
                        <div class="col-9">
                            <h6 class="text-uppercase">                            
                                <li class="list-inline-item">
                                    <i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo date("d-m-Y", strtotime($row['departure_date'])); ?>
                                    <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $row['departure_time']; ?> - <?php echo $row['arrival_time']; ?>
                                </li>
                            </h6>             
                        </div>
                        <div class="col-3 d-flex flex-column">         
                            <!-- Delete button -->
                            <a href="deleteRide.php?id=<?php echo $row["ride_id"]; ?>"class="btn btn-primary">Delete ride</a>  
                        </div>
                    </div> 
                </div>
            </div>
                <?php
                    }
                    // Close connection
                    mysqli_close($con);
                ?> 
        </div>                

      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/locale/da.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>           
                        
                      

    </body>
</html>