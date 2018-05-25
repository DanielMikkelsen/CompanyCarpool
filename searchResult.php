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

<html>

    <head>
        <title>Vestas Carpool: Search results</title>
        <meta name="wievport" content="width=device, initial-scale=1" charset="UTF-8">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">


        <!-- Own CSS link -->
        <link rel="stylesheet" href="searchResult.css">
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
                     Search Results
                </h3>

        <?php
        if (isset($_GET['form_submit'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            if ($_GET['date']) {
                $date = date("Y-m-d", strtotime($_GET['date']));
            } else {
                $date = '';
            }

            
            $sql = "SELECT * FROM Ride 
            JOIN Employee on Employee.employee_id = Ride.employee_id
            WHERE depart_city LIKE '%$from%' AND dest_city LIKE '%$to%' AND departure_date LIKE '%$date' 
            ORDER BY departure_date";
            $query = mysqli_query($con, $sql);
            }
        
            while ($row = mysqli_fetch_array($query)) {
            ?>

            <div id="<?php echo $row['ride_id']; ?>" class="row row-striped event">
                <div class="col-2 text-right">
                    <h1><span class="badge badge-secondary"><?php echo date("d", strtotime($row['departure_date'])); ?></span></h1>
                    <h3><?php echo date("M", strtotime($row['departure_date'])); ?></h3>
                </div>
                <div class="col-10">
                    <h4 class="text-uppercase"><strong><?php echo $row['firstname']; ?> <?php echo $row['lastname']; ?></strong>
                        <li class="list-inline-item pull-right">
                            <?php
                            $x = 1;
                            while ($x <= $row['available_seats']) {
                                echo'<i class="fa fa-user" aria-hidden="true"></i>';
                                $x++;
                                }
                            ?>
                        </li>
                    </h4>

                    <div class="row">
                        <div class="col-9">
                            
                <ul class="list-inline">
                    <li class="list-inline-item"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo date("d-m-Y", strtotime($row['departure_date'])); ?></li>
                    <li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $row['departure_time']; ?> - <?php echo $row['arrival_time']; ?></li>
                </ul>

                <ul class="list-inline">
                <li class="list-inline-item"><i class="fa fa-location-arrow" aria-hidden="true"></i> depature street: <?php echo $row['depart_city']; ?> (<?php echo $row['depart_street']; ?>) - 
                        <?php echo $row['dest_city']; ?> (<?php echo $row['dest_street']; ?>)
                </ul>

                <ul class="list-inline">
                    <li class="list-inline-item"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $row['phone_no']; ?></li>
                    <li class="list-inline-item"><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $row['email']; ?></li>
                    <li class="list-inline-item"><i class="fa fa-briefcase" aria-hidden="true"></i> <?php echo $row['department']; ?> (<?php echo $row['position']; ?>)</li>
                </ul>
                
                        </div>


                    <div class="col-3 d-flex flex-column">         
                    <?php
                    //if available_seat == 0, make this booking unavailable 
                    //and inform the user of it
                        if (!($row['available_seats'] == 0)){ ?>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary pull-right mt-auto" data-toggle="modal" data-target="#exampleModalCenter">
                    Book ride
                    </button>
                    
                        <!-- Modal -->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Booking confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to book this ride?
                                </div>
                                <div class="modal-footer">
                            
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <a href="bookRide.php?id=<?php echo $row["ride_id"]; ?>"
                                    class="btn btn-primary">Book</a>                  
                                </div>
                            </div>
                        </div>
                    </div>


                    </div>
                    </div>


                        
                    <?php 
                        } else { ?>
                            <li class="list-inline-item">
                                <h5><strong> No available seats! </strong></h5>
                            </li>
                    <?php
                        }?>

                </div>
            </div>

         
           


            <?php
                } // Close connection
             mysqli_close($con);
            ?>
        </div>
     </div>
     


        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/locale/da.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>           
                        
                   

    </body>
</html>
