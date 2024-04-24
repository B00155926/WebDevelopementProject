<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Runner</title>
    <link rel="stylesheet" href="../css/validation.css">
</head>
<body>

<div class="container">
    <h1>Basis Path Testing</h1>
    <?php
    require "../src/config.php";
    require "../src/DBconnect.php";
    function testLogin($username, $password, $pdo) {
        // Prepare SQL statement
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user exists and the password is correct
        if ($user && password_verify($password, $user['password'])) {
            return "Path 1: Username and password are correct";
        }

        // Check if the username exists but the password is incorrect
        if ($user) {
            return "Path 2: Username is correct, but password is incorrect";
        }

        // Username does not exist
        return "Path 3: Username is incorrect";
    }

    // Assuming $pdo is your PDO object connected to the database
    echo "Test Path 1: " . testLogin("Mira", "pass", $pdo) . "<br>";
    echo "Test Path 2: " . testLogin("Mira", "pas", $pdo) . "<br>";
    echo "Test Path 3: " . testLogin("NotAvailable", "pam", $pdo) . "<br>";


    ?>


</div>
</body>
</html>


