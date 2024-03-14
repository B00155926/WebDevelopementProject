<?php
/*
adminPage php
*/
?>
<?php
$userId = 1;
$email = 'admin@example.com';

require_once 'Admin.php';
require_once '../src/config.php';
require_once '../src/DBconnect.php';

$admin = new Admin($userId, $username, $password, $email, $pdo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Admin Page</title>
</head>
<body>
<h1>Welcome Administrator!</h1>
<?php
// Display user ID and email

?>
<a href="logIn.php">Please log in</a>

<main>
    <section id="update-inventory">
        <h2>Update Inventory Pages</h2>
        <!-- Placeholder for updating inventory pages form -->
        <p>This section is for updating inventory pages.</p>
        <!-- Call the updateInventoryPage method of the Admin class -->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_inventory'])) {
            $pageId = $_POST['page_id'];
            $newContent = $_POST['new_content'];
            $admin->updateInventoryPage($pageId, $newContent);
            echo "Page ID: " . $pageId . "<br>";
            echo "New Content: " . $newContent . "<br>";

        }
        ?>
        <!-- Update Inventory Form -->
        <form method="post">
            <input type="hidden" name="update_inventory" value="1">
            <label for="page_id">Page ID:</label>
            <input type="text" id="page_id" name="page_id">
            <label for="new_content">New Content:</label>
            <textarea id="new_content" name="new_content"></textarea>
            <input type="submit" value="Update Inventory">
        </form>
    </section>
    <section id="add-stock">
        <h2>Add New Stock</h2>
        <!-- Placeholder for adding new stock form -->
        <p>This section is for adding new stock.</p>
        <!-- Call the addNewStock method of the Admin class -->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_stock'])) {
            $adminId = 1;
            $productId = 1;
            $productName = $_POST['product_name'];
            $quantity = $_POST['quantity'];
            $admin->addNewStock($adminId, $productId, $productName, $quantity);
        }

        ?>
        <!-- Add New Stock Form -->
        <form method="post">
            <input type="hidden" name="add_stock" value="1">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity">
            <input type="submit" value="Add Stock">
        </form>
    </section>
    <section id="handle-low-stock">
        <h2>Handle Low Stock</h2>
        <!-- Placeholder for handling low stock situations form -->
        <p>This section is for handling low stock situations.</p>
        <!-- Call the handleLowStock method of the Admin class -->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['handle_low_stock'])) {
            $productName = $_POST['product_name'];
            $adminId = $_POST['admin_id'];
            $admin->handleLowStock($productName, $adminId);
        }
        ?>
            <?php
            // Fetch all admins
            $admins = $admin->getAllAdmins();
            ?>

            <!-- Handle Low Stock Form -->
            <form method="post">
                <input type="hidden" name="handle_low_stock" value="1">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name">

                <!-- Add a dropdown to select the admin -->
                <label for="admin_id">Admin:</label>
                <select id="admin_id" name="admin_id">
                    <!-- Populate this dropdown with admin options -->
                    <?php
                    // Fetch admin data from the database
                    $admins = $admin->getAllAdmins();

                    // Check if admins were fetched successfully
                    if ($admins) {
                        foreach ($admins as $admin) {
                            // Output an option element for each admin
                            echo '<option value="' . $admin['admin_id'] . '">' . $admin['username'] . '</option>';
                        }
                    } else {
                        // Handle the case where no admins are available
                        echo '<option value="">No admins found</option>';
                    }
                    ?>
                </select>

                <input type="submit" value="Handle Low Stock">
            </form>

    </section>
</main>

<a href="index.php">Back to home</a>
</body>
</html>
