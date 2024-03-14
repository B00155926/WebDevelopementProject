<?php
/*
employeePage php
*/
?>
<?php
require_once 'Employee.php';
require_once '../src/config.php';
require_once '../src/DBconnect.php';

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
        <!-- Call the processOrders method of the Employee class -->
        <?php
        // Code to process orders
        // Update order status in the database
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['process_orders'])) {
            // Process orders here
        }
        ?>
        <!-- Process Orders Form -->
        <form method="post">
            <input type="hidden" name="process_orders" value="1">
            <!-- Add form fields for processing orders -->
            <input type="submit" value="Process Orders">
        </form>
    </section>

    <section id="handle-contact-forms">
        <h2>Handle Contact Forms</h2>
        <!-- Placeholder for handling contact forms -->
        <p>This section is for handling contact forms.</p>
        <!-- Call the handleContactForms method of the Employee class -->
        <?php
        // Code to handle contact forms
        //  Send email notifications or store contact form Profile class
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['handle_contact_forms'])) {
            // Handle contact forms here
        }
        ?>
        <!-- Handle Contact Forms Form -->
        <form method="post">
            <input type="hidden" name="handle_contact_forms" value="1">
            <!-- Add form fields for handling contact forms -->
            <input type="submit" value="Handle Contact Forms">
        </form>
    </section>

    <section id="generate-reports">
        <h2>Generate Reports</h2>
        <!-- Placeholder for generating reports -->
        <p>This section is for generating reports.</p>
        <!-- Call the generateReports method of the Employee class -->
        <?php
        // Code to generate reports
        // Fetch data from the database and generate reports
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_reports'])) {
            // Generate reports here
        }
        ?>
        <!-- Generate Reports Form -->
        <form method="post">
            <input type="hidden" name="generate_reports" value="1">
            <!-- Add form fields for generating reports -->
            <input type="submit" value="Generate Reports">
        </form>
    </section>
</main>

<a href="index.php">Back to home</a>
</body>
</html>
