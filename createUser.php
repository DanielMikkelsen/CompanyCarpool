<?php
// Connect to db
require_once 'dbConnect.php';

// Define variables and initialize with empty values
$firstname = $lastname = $phone_no = $email = $position = $department = $password = "";
$firstname_err = $lastname_err = $phone_no_err = $email_err = $position_err = $department_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Validate email
    $input_email = trim($_POST["email"]);
    if (empty($input_email)) {
        $email_err = "Please, enter an email.";
    } else {
        $email = $input_email;
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

    // Look for field errors before quering the db
    if (empty($firstname_err) && empty($lastname_err) && empty($phone_no_err && $email_err && $position_err && $password)) {
        // Prepare an insert statement
        $sql = "INSERT INTO Employee (firstname, lastname, phone_no,
                email, position, department, password) VALUES (?, ?, ?, ?, ?, 
                ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssissss", $param_firstname, $param_lastname, $param_phone_no, $param_email, $param_position, $param_department, $param_password);

            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_phone_no = $phone_no;
            $param_email = $email;
            $param_position = $position;
            $param_department = $department;
            $param_password = $password;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
                echo mysqli_error($link);
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
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
                                <input type="text" name="password" class="form-control" value="<?php echo $password; ?>">
                                <span class="help-block"><?php echo $password_err; ?></span>
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