<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION['employee_id']) || empty($_SESSION['employee_id'])) {
    header("location: login.php");
    exit;
}

// Include config file
require_once 'dbConnect.php';

// Define variables and initialize with empty values
$depart_city = $depart_street = $depart_street_no = $departure_date = $departure_time = $dest_city = $dest_street = $dest_street_no = $arrival_time = $available_seats = "";
$depart_city_err = $depart_street_err = $depart_street_no_err = $departure_date_err = $departure_time_err = $dest_city_err = $dest_street_err = $dest_street_no_err = $arrival_time_err = $available_seats_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate depart_city
    $input_depart_city = trim($_POST["depart_city"]);
    if (empty($input_depart_city)) {
        $depart_city_err = "Please, enter a departure city.";
    } else {
        $depart_city = $input_depart_city;
    }

    // Validate departure street
    $input_depart_street = trim($_POST["depart_street"]);
    if (empty($input_depart_street)) {
        $depart_street_err = "Please, enter a departure street.";
    } else {
        $depart_street = $input_depart_street;
    }

    // Validate depart_street_no
    $input_depart_street_no = trim($_POST["depart_street_no"]);
    if (empty($input_depart_street_no)) {
        $depart_street_no_err = 'Please, enter an departure street no.';
    } else {
        $depart_street_no = $input_depart_street_no;
    }

    // Validate departure_date
    $input_departure_date = trim($_POST["departure_date"]);
    if (empty($input_departure_date)) {
        $departure_date_err = "Please, enter a departure date.";
    } else {
        $departure_date = date("Y-m-d", strtotime($input_departure_date));
    }

    // Validate departure time
    $input_departure_time = trim($_POST["departure_time"]);
    if (empty($input_departure_time)) {
        $departure_time_err = "Please, enter a departure time.";
    } else {
        $departure_time = $input_departure_time;
    }

    // Validate dest_city
    $input_dest_city = trim($_POST["dest_city"]);
    if (empty($input_dest_city)) {
        $dest_city_err = "Please, enter a destination city.";
    } else {
        $dest_city = $input_dest_city;
    }

    // Validate dest_street
    $input_dest_street = trim($_POST["dest_street"]);
    if (empty($input_dest_street)) {
        $dest_street_err = "Please, enter a destination street.";
    } else {
        $dest_street = $input_dest_street;
    }

    // Validate dest_street_no
    $input_dest_street_no = trim($_POST["dest_street_no"]);
    if (empty($input_dest_street_no)) {
        $dest_street_no_err = "Please, enter a destination street no.";
    } else {
        $dest_street_no = $input_dest_street_no;
    }

    // Validate arrival_time
    $input_arrival_time = trim($_POST["arrival_time"]);
    if (empty($input_arrival_time)) {
        $arrival_time_err = "Please, enter an estimated arrival time.";
    } else {
        $arrival_time = $input_arrival_time;
    }

    // Validate available_seats
    $input_available_seats = trim($_POST["available_seats"]);
    if (empty($input_available_seats)) {
        $available_seats_err = "Please, enter how many available seats you offer.";
    } else {
        $available_seats = $input_available_seats;
    }

    // Check input errors before inserting in database
    if (empty($depart_city_err) && empty($depart_street_err) && empty($depart_street_no_err && $departure_date_err && $departure_time_err && $dest_city_err && $dest_street_err && $dest_street_no_err && $arrival_time_err && $available_seats_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO Ride (arrival_time, departure_date, departure_time, available_seats, employee_id,
            depart_city, depart_street, depart_street_no, dest_city, dest_street, dest_street_no) 
                VALUES (:arrival_time, :departure_date, :departure_time, :available_seats, :employee_id, 
                :depart_city, :depart_street, :depart_street_no,
                :dest_city, :dest_street, :dest_street_no)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':arrival_time', $param_arrival_time, PDO::PARAM_STR);
            $stmt->bindParam(':departure_date', $param_departure_date, PDO::PARAM_STR);
            $stmt->bindParam(':departure_time', $param_departure_time, PDO::PARAM_STR);
            $stmt->bindParam(':available_seats', $param_available_seats, PDO::PARAM_STR);
            $stmt->bindParam(':employee_id', $param_employee_id, PDO::PARAM_INT);
            $stmt->bindParam(':depart_city', $param_depart_city, PDO::PARAM_STR);
            $stmt->bindParam(':depart_street', $param_depart_street, PDO::PARAM_STR);
            $stmt->bindParam(':depart_street_no', $param_depart_street_no, PDO::PARAM_INT);
            $stmt->bindParam(':dest_city', $param_dest_city, PDO::PARAM_STR);
            $stmt->bindParam(':dest_street', $param_dest_street, PDO::PARAM_STR);
            $stmt->bindParam(':dest_street_no', $param_dest_street_no, PDO::PARAM_INT);

            // Set parameters
            $param_arrival_time = $arrival_time;
            $param_departure_date = $departure_date;
            $param_departure_time = $departure_time;
            $param_available_seats = $available_seats;
            $param_employee_id = $_SESSION['employee_id'];
            $param_depart_city = $depart_city;
            $param_depart_street = $depart_street;
            $param_depart_street_no = $depart_street_no;
            $param_dest_city = $dest_city;
            $param_dest_street = $dest_street;
            $param_dest_street_no = $dest_street_no;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                header("location: home.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
}
?>




<!DOCTYPE html>
<html lang="en">


<head>
        <meta charset="utf-8">
        <title>Vestas Carpool: Create Ride</title>
        <meta name="wievport" content="width=device, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

        <!-- Own CSS link -->
        <link rel="stylesheet" href="createRide.css">
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
                        <li class="nav-item active">
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

        <div class="container container-padding">
                <div class="row">
                    <div class="col-md-12">
                        
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <h1 class="text-center">Create ride</h1>
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="leftcontact">
                                            <h4 class="header-description">Where are you going from?</h4>
                                            <div class="form-groups">
                                                <div class="form-group <?php echo (!empty($depart_street_err)) ? 'has-error' : ''; ?>">
                                                    <p>Street</p>
                                                    <span class="icon-case"><i class="fa fa-building-o"></i></span>
                                                    <input type="text" name="depart_street"  value="<?php echo $depart_street; ?>" />
                                                    <span class="help-block"><?php echo $depart_street_err; ?></span>
                                                </div>

                                                <div class="form-group <?php echo (!empty($depart_street_no_err)) ? 'has-error' : ''; ?>">
                                                    <p>Street number</p>
                                                    <span class="icon-case"><i class="fa fa-building-o"></i></span>
                                                    <input type="text" name="depart_street_no"  value="<?php echo $depart_street_no; ?>" />
                                                    <span class="help-block"><?php echo $depart_street_no_err; ?></span>
                                                </div>

                                                <div class="form-group <?php echo (!empty($depart_city_err)) ? 'has-error' : ''; ?>">
                                                    <p>City</p>
                                                    <span class="icon-case"><i class="fa fa-location-arrow"></i></span>
                                                    <input type="text" name="depart_city" value="<?php echo $depart_city; ?>" />
                                                    <span class="help-block"><?php echo $depart_city_err; ?></span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="rightcontact">
                                            <h4 class="header-description">Where are you going to?</h4>

                                                <div class="form-group <?php echo (!empty($dest_street_err)) ? 'has-error' : ''; ?>">
                                                    <p>Street</p>
                                                    <span class="icon-case"><i class="fa fa-location-arrow"></i></span>
                                                    <input type="text" name="dest_street" value="<?php echo $dest_street; ?>" />
                                                    <span class="help-block"><?php echo $dest_street_err; ?></span>
                                                </div>

                                                <div class="form-group <?php echo (!empty($dest_street_no_err)) ? 'has-error' : ''; ?>">
                                                    <p>Street number</p>
                                                    <span class="icon-case"><i class="fa fa-building-o"></i></span>
                                                    <input type="text" name="dest_street_no" value="<?php echo $dest_street_no; ?>"/>
                                                    <span class="help-block"><?php echo $dest_street_no_err; ?></span>
                                                </div>

                                                <div class="form-group <?php echo (!empty($dest_city_err)) ? 'has-error' : ''; ?>">
                                                    <p>City</p>
                                                    <span class="icon-case"><i class="fa fa-building-o"></i></i></span>
                                                    <input type="text" name="dest_city" value="<?php echo $dest_city; ?>" />
                                                    <span class="help-block"><?php echo $dest_city_err; ?></span>
                                                </div>

                                        </div>

                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col">
                                        <div class="leftcontact">
                                            <h4 class="header-description">Travel details</h4>
                                                
                                                <div class="form-group date <?php echo (!empty($departure_date_err)) ? 'has-error' : ''; ?>" id="datetimepicker4" data-target-input="nearest">
                                                    <p>Depature date (DD-MM-YYYY)</p>
                                                    <span class="icon-case input-group-text" data-target="#datetimepicker4" data-toggle="datetimepicker"><i class="fa fa-calendar"></i></span>
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker4" name="departure_date" value="<?php echo $departure_date; ?>"/>
                                                    <span class="help-block"><?php echo $departure_date_err; ?></span>
                                                </div>

                                                <div class="form-group <?php echo (!empty($available_seats_err)) ? 'has-error' : ''; ?>">
                                                    <p>Number of available seats</p>
                                                    <span class="icon-case"><i class="fa fa-user"></i></span>
                                                    <input type="text" name="available_seats"value="<?php echo $available_seats; ?>"/>
                                                    <span class="help-block"><?php echo $available_seats_err; ?></span>
                                                </div>

                                        </div>

                                        <div class="rightcontact">
                                            <h4 class="header-description"></h4>
                                        
                                                <div class="form-group date <?php echo (!empty($departure_time_err)) ? 'has-error' : ''; ?>" id="datetimepicker1" data-target-input="nearest">
                                                    <p>Departure time (HH:MM)</p>
                                                    <span class="icon-case" data-target="#datetimepicker1" data-toggle="datetimepicker"><i class="fa fa-clock-o"></i></span>
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" name="departure_time" value="<?php echo $departure_time; ?>" />
                                                    <span class="help-block"><?php echo $departure_time_err; ?></span>
                                                </div>

                                                <div class="form-group date <?php echo (!empty($arrival_time_err)) ? 'has-error' : ''; ?>" id="datetimepicker2" data-target-input="nearest">
                                                    <p>Estimated arrival (HH:MM)</p>
                                                    <span class="icon-case" data-target="#datetimepicker2" data-toggle="datetimepicker"><i class="fa fa-clock-o"></i></span>
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker2" name="arrival_time" value="<?php echo $arrival_time; ?>"/>
                                                    <span class="help-block"><?php echo $arrival_time_err; ?></span>
                                                </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <input type="submit" class="btn btn-primary pull-right" value="Submit">
                                        <a href="home.php" class="btn btn-secondary pull-right">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
    
                    </div>
                </div>        

        </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/locale/da.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $('#datetimepicker4').datetimepicker({
                format: 'DD-MM-YYYY'
            });
        }); 

        $(function () {
            $('#datetimepicker1').datetimepicker({
                format: 'LT',
                stepping: 5
            });
        });

        $(function () {
            $('#datetimepicker2').datetimepicker({
                format: 'LT',
                stepping: 5
            });
        });
    </script>

  </body>

  </html>