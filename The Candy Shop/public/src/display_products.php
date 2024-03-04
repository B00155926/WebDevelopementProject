<?php

// Connect to the database
$hostname = 'localhost';
$username = 'root';
$password = 'Gunners@1987';
$database = 'The_Candy_Shop';

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the current maximum Product_ID from the database
$sql = "SELECT MAX(Product_ID) AS max_id FROM product";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $next_product_id = $row["max_id"] + 1;
} else {
    // If no products are present in the table, start with ID 1
    $next_product_id = 1;
}

// Insert the first product into the database
$name1 = 'Chocolate';
$description1 = 'Milk Chocolate';
$price1 = 3.00;
$stockLevel1 = 100;

$sql1 = "INSERT INTO product (Product_ID, Name, Description, Price, Stock_Level) 
         VALUES ($next_product_id, '$name1', '$description1', $price1, $stockLevel1)";

if ($conn->query($sql1) !== TRUE) {
    echo "Error inserting product 1: " . $conn->error;
}

// Increment the Product_ID for the next product
$next_product_id++;

// Insert the second product into the database
$name2 = 'Jellies';
$description2 = 'Sour Candy';
$price2 = 2.00;
$stockLevel2 = 50;

$sql2 = "INSERT INTO product (Product_ID, Name, Description, Price, Stock_Level) 
         VALUES ($next_product_id, '$name2', '$description2', $price2, $stockLevel2)";

if ($conn->query($sql2) !== TRUE) {
    echo "Error inserting product 2: " . $conn->error;
}

// Close the connection
$conn->close();

?>

