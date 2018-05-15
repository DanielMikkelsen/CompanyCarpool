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
        $lastname_err = 'Please, enter an address.';
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
    if (empty($firstname_err) && empty($lastname_err) && empty($phone_no_err && $email_err && $position_err && $password)) {

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
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Vestas Carpool: Create User</title>
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
                            <h2>Create User</h2>
                        </div>
                        <p>Please, fill this form and hit submit when you are done to make a new user.</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                                <label>Firstname</label>
                                <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                                <span class="help-block"><?php echo $firstname_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                                <label>Lastname</label>
                                <textarea name="lastname" class="form-control"><?php echo $lastname; ?></textarea>
                                <span class="help-block"><?php echo $lastname_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($phone_no_err)) ? 'has-error' : ''; ?>">
                                <label>Phone number.</label>
                                <input type="text" name="phone_no" class="form-control" value="<?php echo $phone_no; ?>">
                                <span class="help-block"><?php echo $phone_no_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                <label>Email.</label>
                                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                                <span class="help-block"><?php echo $email_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($position_err)) ? 'has-error' : ''; ?>">
                                <label>Position in Vestas.</label>
                                <input type="text" name="position" class="form-control" value="<?php echo $position; ?>">
                                <span class="help-block"><?php echo $position_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($department_err)) ? 'has-error' : ''; ?>">
                                <label>Department in Vestas.</label>
                                <input type="text" name="department" class="form-control" value="<?php echo $department; ?>">
                                <span class="help-block"><?php echo $department_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                <label>Password.</label>
                                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                                <span class="help-block"><?php echo $password_err; ?></span>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="index.php" class="btn btn-default">Cancel</a>
                            <p>Already have an account? <a href="login.php">Login here</a>.</p>
                        </form>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>