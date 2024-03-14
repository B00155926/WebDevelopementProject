<?php
/**
 * Configuration for database connection with credentials
 */
$host = "localhost";
$username = "root";
$password = "Strigatare!1";
$dbname = "The_Candy_Shop";
$dsn = "mysql:host=$host;dbname=$dbname";
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
);

// Create a PDO instance
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit(); // Terminate script execution if connection fails
}
?>
