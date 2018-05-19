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

//tutorial used for this page: 
//https://www.allphptricks.com/insert-view-edit-and-delete-record-from-database-using-php-and-mysqli/

//employee to show rides from
$employee_id = $_SESSION['employee_id'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Vestas Carpool: My Rides</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            .wrapper{
                width: 500px;
                margin: 0 auto;
            }
        </style>
    </head>
    <body>
        <div class="form">
            <div class="container-fluid">
                <a href="myBookings.php" class="btn btn-default">View rides I've booked.</a>
                <a href="myAccount.php" class="btn btn-default">Edit account details.</a>
                <a href="index.php" class="btn btn-default">Back to front page</a>
            </div>
            <h2>My Offered Rides</h2>
            <table width="100%" border="1" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th><strong>From</strong></th>
                        <th><strong>To</strong></th>
                        <th><strong>Date</strong></th>
                        <th><strong>Delete Ride</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "Select * from Ride WHERE employee_id = '$employee_id'";
                    $result = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr><td align="left"><?php echo $row["depart_city"]; ?></td>
                            <td align="left"><?php echo $row["dest_city"]; ?></td>
                            <td align="left"><?php echo $row["departure_date"]; ?></td>
                            <td align="left">
                                <a href="deleteRide.php?id=<?php echo $row["ride_id"]; ?>"
                                   onclick="return confirm('Are you sure you want to delete this ride?');"
                                   >Delete Ride</a>
                            </td>
                        </tr>
    <?php
}
// Close connection
mysqli_close($con);
?>
                </tbody>
            </table>
        </div>
    </body>
</html>