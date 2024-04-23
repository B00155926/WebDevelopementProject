<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Runner</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<div class="container">
    <h1>Test Results</h1>
    <?php
    // Check if the main method has already been called
    if (!defined('RUNNER_MAIN_CALLED')) {
    define('RUNNER_MAIN_CALLED', true);

    // Classes here
    require_once 'Runner.php';
    require_once 'User.php';
    require_once 'Customer.php';
    require_once 'Admin.php';
    require_once 'Profile.php';
    require_once 'Product.php';
    require_once 'Order.php';


        // Run the main method of the Runner class
        Runner::main();
    }

    ?>
</div>
</body>
</html>
