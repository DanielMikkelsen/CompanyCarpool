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
        $departure_date = $input_departure_date;
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
                header("location: index.php");
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
        <meta charset="UTF-8">
        <title>Vestas Carpool: Create Ride</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            .wrapper{
                width: 500px;
                margin: 0 auto;
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h2>Create Ride</h2>
                        </div>
                        <p>Please, fill this form and hit submit when you are done to make a new ride.</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group <?php echo (!empty($depart_city_err)) ? 'has-error' : ''; ?>">
                                <label>Departure city</label>
                                <input type="text" name="depart_city" class="form-control" value="<?php echo $depart_city; ?>">
                                <span class="help-block"><?php echo $depart_city_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($depart_street_err)) ? 'has-error' : ''; ?>">
                                <label>Departure street</label>
                                <textarea name="depart_street" class="form-control"><?php echo $depart_street; ?></textarea>
                                <span class="help-block"><?php echo $depart_street_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($depart_street_no_err)) ? 'has-error' : ''; ?>">
                                <label>Departure street number.</label>
                                <input type="text" name="depart_street_no" class="form-control" value="<?php echo $depart_street_no; ?>">
                                <span class="help-block"><?php echo $depart_street_no_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($departure_date_err)) ? 'has-error' : ''; ?>">
                                <label>Departure date (write as YYYY-MM-DD).</label>
                                <input type="text" name="departure_date" class="form-control" value="<?php echo $departure_date; ?>">
                                <span class="help-block"><?php echo $departure_date; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($departure_time_err)) ? 'has-error' : ''; ?>">
                                <label>Departure time (write as HH:MM).</label>
                                <input type="text" name="departure_time" class="form-control" value="<?php echo $departure_time; ?>">
                                <span class="help-block"><?php echo $departure_time_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($dest_city_err)) ? 'has-error' : ''; ?>">
                                <label>Destination city</label>
                                <input type="text" name="dest_city" class="form-control" value="<?php echo $dest_city; ?>">
                                <span class="help-block"><?php echo $dest_city_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($dest_street_err)) ? 'has-error' : ''; ?>">
                                <label>Destination street</label>
                                <textarea name="dest_street" class="form-control"><?php echo $dest_street; ?></textarea>
                                <span class="help-block"><?php echo $dest_street_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($dest_street_no_err)) ? 'has-error' : ''; ?>">
                                <label>Destination street number.</label>
                                <input type="text" name="dest_street_no" class="form-control" value="<?php echo $dest_street_no; ?>">
                                <span class="help-block"><?php echo $dest_street_no_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($arrival_time_err)) ? 'has-error' : ''; ?>">
                                <label>Estimated time of arrival (write as HH:MM).</label>
                                <input type="text" name="arrival_time" class="form-control" value="<?php echo $arrival_time; ?>">
                                <span class="help-block"><?php echo $arrival_time_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($available_seats_err)) ? 'has-error' : ''; ?>">
                                <label>Available seats.</label>
                                <input type="text" name="available_seats" class="form-control" value="<?php echo $available_seats; ?>">
                                <span class="help-block"><?php echo $available_seats_err; ?></span>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="index.php" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>