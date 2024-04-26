<?php
/*
login_process php from logIn php
*/
?>
<?php
session_start();

// Establish database connection
$pdo = new PDO("mysql:host=localhost;dbname=The_Candy_Shop", 'root', 'Strigatare!1');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query database to check if user exists
    $stmt = $pdo->prepare("SELECT * FROM User WHERE email = ?");
    $stmt->execute([$email]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists and password matches
    if ($userData && password_verify($password, $userData['password'])) {
        // Set user role in session
        $_SESSION['user_id'] = $userData['user_id'];
        // Display user data
        echo "<h2>User Details:</h2>";
        echo "User ID: " . $userData['user_id'] . "<br>";
        echo "Email: " . $userData['email'] . "<br>";


        // Redirect to dashboard or home page
        header("Location: index.php");
        exit(); // Stop further execution
    } else {
        // Invalid credentials, redirect back to login page with error message
        header("Location: index.php?error=1");
        exit(); // Stop further execution
    }
}
?>
