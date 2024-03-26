<?php

global $email, $userId;
require_once 'User.php';
require_once 'Employee.php';
require_once '../src/config.php';
require_once '../src/DBconnect.php';


// Process orders if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['process_orders'])) {
    try {
        // Create a PDO instance
        $pdo = new PDO($dsn, $username, $password, $options);

        // Create an instance of the Employee class and pass the $pdo instance
        $employee = new Employee($userId, $username, $password, 'employee', $pdo);

        // Process orders
        $employee->processOrders();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit(); // Terminate script execution if connection or query fails
    }
}

// Check if the form is submitted to handle contact forms
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['handle_contact_forms'])) {
    try {
        // Retrieve unprocessed customer profiles from the Profile table
        $stmt = $pdo->prepare("SELECT * FROM Profile WHERE role = 'customer' AND processed = 0");
        $stmt->execute();
        $unprocessedProfiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if there are unprocessed profiles
        if (!empty($unprocessedProfiles)) {
            // Process profiles
            foreach ($unprocessedProfiles as $profile) {
                //  Send an email to the customer using their email address
                $to = $profile['email'];
                $subject = "Regarding your recent inquiry";
                $message = "Dear {$profile['firstname']} {$profile['lastname']},\n\nWe have received your inquiry and will get back to you shortly.\n\nBest regards,\nThe Employee";
                $headers = "From: employee@email.com";

                // Send email
                $mailSent = mail($to, $subject, $message, $headers);

                if ($mailSent) {
                    // If the email is sent successfully, update the processed flag in the Profile table
                    $stmt = $pdo->prepare("UPDATE Profile SET processed = 1 WHERE profile_id = :profile_id");
                    $stmt->execute(['profile_id' => $profile['profile_id']]);
                    echo "<p>Message sent to: {$profile['firstname']} {$profile['lastname']}</p>";
                } else {
                    echo "<p>Failed to send message to {$profile['firstname']} {$profile['lastname']}</p>";
                }
            }
            // Redirect to avoid resubmission on page refresh
            header("Location: employeePage.php");
            exit;
        }
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
    }
}
// Fetch unprocessed customer profiles
$stmt = $pdo->prepare("SELECT * FROM Profile WHERE role = 'customer' AND processed = 0");
$stmt->execute();
$unprocessedProfiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Employee Page</title>
</head>
<body>
<h1>Welcome Employee!</h1>

<main>
    <section id="process-orders">
        <h2>Process Orders</h2>
        <!-- Placeholder for processing orders form -->
        <p>This section is for processing orders.</p>
        <!-- Database connection -->
        <?php
        require_once '../src/config.php';
        require_once '../src/DBconnect.php';

        // Retrieve pending orders
        $stmt = $pdo->query("SELECT * FROM Product WHERE description = 'pending'");
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($orders)) {
            echo "<p>All orders have been processed successfully.</p>";
        } else {
            // Display orders
            echo "<div class='order-container'>";
            foreach ($orders as $order) {
                echo "<div class='order'>";
                echo "<p>Order ID: {$order['product_id']}</p>";
                echo "<p>Name: {$order['name']}</p>";
                echo "<p>Price: {$order['price']}</p>";
                echo "<p>Quantity: {$order['quantity']}</p>";
                echo "<p>Total: {$order['total']}</p>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='product_id' value='{$order['product_id']}'>";
                echo "<input type='submit' name='process_order' value='Process Order'>";
                echo "</form>";
                echo "</div>";
            }
            echo "</div>";


            // Process order if form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['process_order'])) {
                $product_id = $_POST['product_id'];
                // Update order status to processed
                $stmt = $pdo->prepare("UPDATE Product SET description = 'processed' WHERE product_id = :product_id");
                $stmt->execute(['product_id' => $product_id]);
                // Refresh the page to reflect the updated order status
                header("Location: employeePage.php");
                exit;
            }
        }
        ?>
    </section>

    <section id="handle-contact-forms">
        <h2>Handle Contact Forms</h2>
        <!-- Placeholder for handling contact forms -->
        <p>This section is for handling contact forms.</p>
        <!-- Display customer details if there are unprocessed profiles -->
        <?php if (!empty($unprocessedProfiles)) : ?>
            <h2>New Customers:</h2>
            <ul>
                <?php foreach ($unprocessedProfiles as $profile) : ?>
                    <li>
                        <strong>Name:</strong> <?php echo "{$profile['firstname']} {$profile['lastname']}"; ?><br>
                        <strong>Email:</strong> <?php echo $profile['email']; ?><br>
                        <strong>Address:</strong> <?php echo $profile['address']; ?><br>
                        <strong>Telephone:</strong> <?php echo $profile['telephone']; ?><br>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>No new customers to be processed at the moment.</p>
        <?php endif; ?>
        <!-- Handle Contact Forms Form -->
        <form method="post">
            <input type="hidden" name="handle_contact_forms" value="1">
            <input type="submit" value="Handle Contact Forms">
        </form>
    </section>
    <section id="generate-reports">
        <h2>Generate Reports</h2>
        <p>This section is for generating reports.</p>
        <?php
        // Check if the form is submitted to generate reports
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_reports'])) {
            try {
                // Create a PDO instance
                $pdo = new PDO($dsn, $username, $password, $options);

                // Query to retrieve total sales for each product from the Product table
                $stmt = $pdo->prepare("SELECT product_id, SUM(quantity) AS total_quantity, SUM(total) AS total_sales 
                   FROM Product 
                   GROUP BY product_id");
                $stmt->execute();
                $salesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Get the current date
                $currentDate = date('Y-m-d');

                // Initialize total sales
                $totalSales = 0;

                // Insert sales data into the Employee table
                foreach ($salesData as $sale) {
                    $productId = $sale['product_id'];
                    $quantitySold = $sale['total_quantity'];
                    $totalSales += $sale['total_sales'];

                    // Insert the sale into the Employee table
                    $stmt = $pdo->prepare("INSERT INTO Employee (sale_date, product_id, quantity_sold, total_sales) 
                       VALUES (:sale_date, :product_id, :quantity_sold, :total_sales)");
                    $stmt->execute([
                        'sale_date' => $currentDate,
                        'product_id' => $productId,
                        'quantity_sold' => $quantitySold,
                        'total_sales' => $sale['total_sales']
                    ]);
                }
                // Display success message
                echo "<p>Daily total sales for $currentDate: $" . number_format($totalSales, 2) . "</p>";

            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        ?>
        <!-- Generate Reports Form -->
        <form method="post">
            <input type="hidden" name="generate_reports" value="1">
            <input type="submit" value="Generate Reports">
        </form>
    </section>

</main>
<a href="index.php">Back to home</a>
</body>
</html>