<?php
/*
registration php/ form
*/
?>
<?php
require_once 'session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/registration.css">
</head>
<body>
<h1>Register</h1>

<?php
require_once '../src/config.php';
require_once 'common.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = []; // Array to store validation errors

    // Validate first name
    if (empty($_POST["firstname"])) {
        $errors[] = "First name is required.";
    } elseif (!preg_match("/^[a-zA-Z'-]+$/", $_POST["firstname"])) {
        $errors[] = "Invalid first name format.";
    }

    // Validate last name
    if (empty($_POST["lastname"])) {
        $errors[] = "Last name is required.";
    } elseif (!preg_match("/^[a-zA-Z'-]+$/", $_POST["lastname"])) {
        $errors[] = "Invalid last name format.";
    }

    // Validate email
    if (empty($_POST["email"])) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate telephone
    if (empty($_POST["telephone"])) {
        $errors[] = "Telephone is required.";
    } elseif (!preg_match("/^[0-9]+$/", $_POST["telephone"])) {
        $errors[] = "Invalid telephone format.";
    }

    // Validate username
    if (empty($_POST["username"])) {
        $errors[] = "Username is required.";
    }

    // Validate password
    if (empty($_POST["password"])) {
        $errors[] = "Password is required.";
    }

    // If there are no errors, proceed with registration
    if (empty($errors)) {
        try {
            require_once '../src/DBconnect.php';
            require_once 'common.php';

            // Collect form data
            $new_user = array(
                "firstname" => escape($_POST['firstname']),
                "lastname" => escape($_POST['lastname']),
                "address" => escape($_POST['address']),
                "email" => escape($_POST['email']),
                "telephone" => escape($_POST['telephone']),
                "role" => escape($_POST['role']),
                "username" => escape($_POST['username']), // Added username field
                "password" => password_hash($_POST['password'], PASSWORD_DEFAULT), // Hashed password
            );

            // Prepare and execute SQL query to insert into user table
            $sql_user = "INSERT INTO User (firstname, lastname, address, email, telephone, role, username, password) 
                         VALUES (:firstname, :lastname, :address, :email, :telephone, :role, :username, :password)";
            $statement_user = $connection->prepare($sql_user);
            $statement_user->execute($new_user);

            // If the user role is 'customer', insert additional details into the profile table
            if ($new_user['role'] === 'customer') {
                // Prepare and execute SQL query to insert into profile table
                $sql_profile = "INSERT INTO Profile (user_id, firstname, lastname, address, email, telephone, role, username, password) 
                                VALUES (:user_id, :firstname, :lastname, :address, :email, :telephone, :role, :username, :password)";
                $statement_profile = $connection->prepare($sql_profile);
                $new_user['user_id'] = $connection->lastInsertId(); // Get the ID of the inserted user
                $statement_profile->execute($new_user);
            }

            echo "User registered successfully!";
        } catch(PDOException $error) {
            echo "Error: " . $error->getMessage();
        }
    } else {
        // If there are errors, display them to the user
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}
?>
<form method="post">
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname" required>
    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname" required>
    <label for="address">Address</label>
    <input type="text" name="address" id="address">
    <label for="email">E-mail</label>
    <input type="text" name="email" id="email" required>
    <label for="telephone">Contact Number</label>
    <input type="text" name="telephone" id="telephone" required>
    <label for="username">Username</label>
    <input type="text" name="username" id="username" required>
    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>

    <label for="role">Role</label>
    <select name="role" id="role" required>
        <option value="customer">Customer</option>
        <option value="admin">Admin</option>
        <option value="employee">Employee</option>
    </select>
    <input type="submit" name="submit" value="Submit">
</form>
<a href="index.php">Back to home</a>
</body>
</html>
