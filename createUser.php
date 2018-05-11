<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <title>Vestas Carpool</title>
    </head>
    <body>
        <h1>Create User</h1>
        <form method="post" action="create.php">
            <p>Firstname: </p>
            <input name="firstName" type="text">
            <p>Lastname: </p>
            <input name="lastName" type="text">
            <p>Email: </p>
            <input name="email" type="text">
            <p>Phone no.: </p>
            <input name="phoneNo" type="text">
            <p>Department in Vestas: </p>
            <input name="department" type="text">
            <p>Position in Vestas: </p>
            <input name="position" type="text">
            <p>Password </p>
            <input name="password" type="text">
            <br>
            <input type="submit" name="submit" value="submit">
        </form>
        <?php
        require_once("dbConnect.php");
        if (isset($_POST['submit'])) {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $phoneNo = $_POST['phoneNo'];
            $department = $_POST['department'];
            $position = $_POST['position'];
            $password = $_POST['password'];
            //connect to database
            db();
            global $link;
            $query = "INSERT INTO Employee(firstname, lastname, email, phone_no,
                email, department, position, password)     
    		VALUES ('$firstName', '$lastName', '$email, '$phoneNo',
                    '$department', '$position', '$password')";
            $insertUser = mysqli_query($link, $query);
            if ($insertUser) {
                echo "successfully";
            } else {
                echo mysqli_error($link);
            }
            mysqli_close($link);
        }
        ?>
    </body>
</html>
