
<?php
$userId = 1; //user ID
$email = 'B00155926@mytudublin.com';

require_once 'User.php';
require_once 'Admin.php';
require_once '../src/config.php';
require_once '../src/DBconnect.php';

// Instantiate Admin class
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

<main>
    <section id="update-inventory">
        <h2>Update Inventory Pages</h2>
        <p>This section is for updating inventory pages.</p>

        <!-- Update Inventory Form -->
        <form method="post">
            <input type="hidden" name="update_inventory" value="1">
            <label for="page_id">Page ID:</label>
            <input type="text" id="page_id" name="page_id">
            <label for="new_content">New Content:</label>
            <textarea id="new_content" name="new_content"></textarea>
            <input type="submit" value="Update Inventory">
        </form>
        <?php
        // Check if the form for updating inventory pages has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_inventory'])) {
            $pageId = $_POST['page_id'];
            $newContent = $_POST['new_content'];

            // Call the updateInventoryPage method of the Admin class
            $result = $admin->updateInventoryPage($pageId, $newContent);
            if ($result) {
                echo "Inventory page updated successfully.";
            } else {
                echo "Failed to update inventory page.";
            }
        }
        ?>
    </section>

    <section id="add-stock">
        <h2>Add New Stock</h2>
        <p>This section is for adding new stock.</p>

        <!-- Add New Stock Form -->
        <form method="post">
            <input type="hidden" name="add_stock" value="1">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity">
            <label for="total_products_available">Total Products Available:</label>
            <input type="number" id="total_products_available" name="total_products_available">
            <input type="submit" value="Add Stock">
        </form>

        <?php
        // Check if the form for adding new stock has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_stock'])) {
            $productName = $_POST['product_name'];
            $quantity = $_POST['quantity'];
            $totalProductsAvailable = $_POST['total_products_available'];

            // Call the addNewStock method of the Admin class
            $result = $admin->addNewStock($productName, $quantity, $totalProductsAvailable);
            if ($result) {
                echo "New stock added successfully.";
            } else {
                echo "Failed to add new stock. Please try again.";
            }
        }
        ?>
    </section>

    <section id="handle-low-stock">
        <h2>Handle Low Stock</h2>
        <p>This section is for handling low stock situations.</p>
        <!-- Handle Low Stock Form -->
        <form method="post">
            <input type="hidden" name="handle_low_stock" value="1">
            <!-- Add a dropdown to select the admin -->
            <label for="admin_id">Admin:</label>
            <select id="admin_id" name="admin_id">
                <!-- Populate this dropdown with admin options -->
                <?php
                // Fetch admin data from the database using the Admin class
                $admins = $admin->getAllAdmins();

                // Check if admins were fetched successfully
                if ($admins) {
                    foreach ($admins as $adminData) {
                        // Output an option element for each admin
                        echo '<option value="' . $adminData['admin_id'] . '">' . $adminData['username'] . '</option>';
                    }
                } else {
                    // Handle the case where no admins are available
                    echo '<option value="">No admins found</option>';
                }
                ?>
            </select>
            <input type="submit" value="Handle Low Stock">
        </form>
        <?php
        // Check if the form for handling low stock situations has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['handle_low_stock'])) {
            // Ensure that an admin ID is selected before calling handleLowStock()
            if (isset($_POST['admin_id'])) {
                $adminId = $_POST['admin_id'];
                $result = $admin->handleLowStock($adminId);
                if ($result) {
                    echo "Low stock handled successfully.";
                } else {
                    echo "Failed to handle low stock.";
                }
            } else {
                echo "Please select an admin.";
            }
        }
        ?>
    </section>

</main>

<a href="index.php">Back to home</a>
</body>
</html>
