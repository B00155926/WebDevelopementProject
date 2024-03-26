<?php
/*
logIn php to check details
*/
?>
<?php
require_once 'session.php';
require_once '../src/config.php';
require_once 'Admin.php';
require_once 'Employee.php';
require_once 'Customer.php';
require_once 'User.php';
session_start();

if(isset($_POST['Submit'])) {
    $submittedUsername = $_POST['Username'];
    $submittedPassword = $_POST['Password'];

    // Check if the provided username and password match any records in the user table
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$submittedUsername]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($submittedPassword, $user['password'])) {
        // Credentials are correct, retrieve user data
        $username = $user['username'];
        $email = $user['email'];
        $role = $user['role'];


        // Create an instance of the appropriate user class based on the role
        switch ($role) {
            case 'admin':
                $user = new Admin(null, $username, null, $email, $pdo);
                break;
            case 'employee':
                $user = new Employee(null, $username, null, $role, $pdo);
                break;
            case 'customer':
                $user = new Customer(null, $username, null, $email, $pdo);
                break;
            default:
                // Invalid role
                echo "Invalid role";
                exit();
        }


        // Redirect based on the role of the authenticated user
        if ($user instanceof Admin) {
            // Insert the admin into the admin table
            $sql = "INSERT INTO admin (user_id) VALUES (?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user->getUserId()]);

            // Redirect to the admin page
            header("Location: adminPage.php");
            exit();
        } elseif ($user instanceof Employee) {
            header("Location: employeePage.php");
            exit();
        } elseif ($user instanceof Customer) {
            header("Location: index.php");
            exit();
        } else {
            // Authentication failed
            echo "Invalid username or password";
        }
    } else {
        // Authentication failed
        echo "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" type="text/css" href="../css/registration.css">
</head>
<body>
<h1>Log In</h1>
<div class="container">
    <form action="logIn.php" method="post" name="Login_Form" class="form-signin">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputUsername">Username</label>
        <input name="Username" type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword">Password</label>
        <input name="Password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <input name="Submit" value="Login" class="button" type="submit"</input>
    </form>
    <a href="index.php">Back to home</a>
</div>
</body>
</html>