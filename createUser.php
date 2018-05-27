<?php
// Include config file
require_once 'dbConnect.php';

// Define variables and initialize with empty values
$firstname = $lastname = $phone_no = $email = $position = $department = $password = "";
$firstname_err = $lastname_err = $phone_no_err = $email_err = $position_err = $department_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter a email.";
    } else {
        // Prepare a select statement
        $sql = "SELECT employee_id FROM Employee WHERE email = :email";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':email', $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Validate firstname
    $input_firstname = trim($_POST["firstname"]);
    if (empty($input_firstname)) {
        $firstname_err = "Please, enter a firstname.";
    } else {
        $firstname = $input_firstname;
    }

    // Validate lastname
    $input_lastname = trim($_POST["lastname"]);
    if (empty($input_lastname)) {
        $lastname_err = 'Please, enter a lastname.';
    } else {
        $lastname = $input_lastname;
    }

    // Validate phone number
    $input_phone_no = trim($_POST["phone_no"]);
    if (empty($input_phone_no)) {
        $phone_no_err = "Please, enter a phone number.";
    } else {
        $phone_no = $input_phone_no;
    }

    // Validate position
    $input_position = trim($_POST["position"]);
    if (empty($input_position)) {
        $position_err = "Please, enter your position in Vestas.";
    } else {
        $position = $input_position;
    }


    // Validate department
    $input_department = trim($_POST["department"]);
    if (empty($input_department)) {
        $department_err = "Please, enter your department in Vestas.";
    } else {
        $department = $input_department;
    }

    // Validate password
    $input_password = trim($_POST["password"]);
    if (empty($input_password)) {
        $password_err = "Please, enter a password.";
    } else {
        $password = $input_password;
    }

    // Check input errors before inserting in database
    if (empty($firstname_err) && empty($lastname_err) && empty($phone_no_err) && empty($email_err) && empty($department_err) && empty($position_err) && empty($password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO Employee (firstname, lastname, phone_no,
                email, position, department, password) VALUES (:firstname, :lastname, :phone_no, :email, :position, :department, :password)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':firstname', $param_firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $param_lastname, PDO::PARAM_STR);
            $stmt->bindParam(':phone_no', $param_phone_no, PDO::PARAM_INT);
            $stmt->bindParam(':email', $param_email, PDO::PARAM_STR);
            $stmt->bindParam(':position', $param_position, PDO::PARAM_STR);
            $stmt->bindParam(':department', $param_department, PDO::PARAM_STR);
            $stmt->bindParam(':password', $param_password, PDO::PARAM_STR);

            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_phone_no = $phone_no;
            $param_email = $email;
            $param_position = $position;
            $param_department = $department;
            $param_password = $password;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                header("location: login.php");
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
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Vestas Carpool</title>
        <meta name="wievport" content="width=device, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

        <!-- Own CSS link -->
        <link rel="stylesheet" href="createUser.css">

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


<div class="container py-5 container-header">
            <div class="row justify-content-center align-self-center">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <h3> Register </h3>
                           <p>Please, fill this form and hit submit when you are done to make a new user.</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                        
                        <div class="form-group row <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">Firstname</label>
                            <div class="col-sm-9">
                            <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                            <span class="help-block"><?php echo $firstname_err; ?></span>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">Lastname</label>
                            <div class="col-sm-9">
                            <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                            <span class="help-block"><?php echo $lastname_err; ?></span>
                            </div>
                        </div>
                         <div class="form-group row <?php echo (!empty($position_err)) ? 'has-error' : ''; ?>">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">Position</label>
                            <div class="col-sm-9">
                            <input type="text" name="position"  class="form-control" value="<?php echo $position; ?>">
                            <span class="help-block"><?php echo $position_err; ?></span>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($department_err)) ? 'has-error' : ''; ?>">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">Department</label>
                            <div class="col-sm-9">
                            <input type="text" name="department" class="form-control"  value="<?php echo $department; ?>">
                            <span class="help-block"><?php echo $department_err; ?></span>
                            </div>
                        </div>    
            
                        <div class="form-group row <?php echo (!empty($phone_no_err)) ? 'has-error' : ''; ?>">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">Phone number</label>
                            <div class="col-sm-9">
                            <input type="text" name="phone_no" class="form-control" value="<?php echo $phone_no; ?>">
                            <span class="help-block"><?php echo $phone_no_err; ?></span>
                            </div>
                        </div>

                        <div class="form-group row <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err; ?></span>
                            </div>
                        </div>
                
                        <div class="form-group row <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                            <span class="help-block"><?php echo $password_err; ?></span>
                            </div>
                        </div>
                            <input type="submit" class="btn btn-primary pull-right" value="Submit">
                            <a href="index.php" class="btn btn-secondary pull-right">Cancel</a>
                            <p>Already have an account? <a href="login.php">Login here</a>.</p>
                        </form>

                        </div>


                    </div>
                    <!--/row-->

                </div>
                <!--/col-->
            </div>
            <!--/row-->
        </div>
        <!--/container-->
    </body>
</html>