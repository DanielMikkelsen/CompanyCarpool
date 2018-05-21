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
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

        <!-- Own CSS link -->
        <link rel="stylesheet" href="searchResult.css">

        <title>Vestas Carpool: Search results</title>
    </head>
    <body>

        <?php
        if (isset($_GET['form_submit'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $from = preg_replace("#[^0-9a-z]#i", "", $from);
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
                    <h4 class="text-uppercase"><strong><?php echo $row['firstname']; ?> <?php echo $row['lastname']; ?></strong></h4>

                    <ul class="list-inline">
                        <li class="list-inline-item"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo date("d-m-Y", strtotime($row['departure_date'])); ?></li>
                        <li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $row['departure_time']; ?> - <?php echo $row['arrival_time']; ?></li>

                    </ul>
                    <ul class="list-inline">
                        <li class="list-inline-item"><i class="fa fa-location-arrow" aria-hidden="true"></i> <?php echo $row['depart_city']; ?> (<?php echo $row['depart_street']; ?>) - 
                            <?php echo $row['dest_city']; ?> (<?php echo $row['dest_street']; ?>)
                    </ul>
                    <ul class="list-inline">
                        <li class="list-inline-item"><i class="fa fa-briefcase" aria-hidden="true"></i> <?php echo $row['department']; ?> (<?php echo $row['position']; ?>)</li>
                    </ul>
                    <ul class="list-inline">
                        <li class="list-inline-item"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $row['phone_no']; ?></li>
                        <li class="list-inline-item"><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $row['email']; ?></li>
                    </ul>
                </div>
            </div>



            <?php
        }
        // Close connection
        mysqli_close($con);
        ?>

    </body>
</html>
