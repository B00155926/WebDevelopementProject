<?php
require_once 'User.php';

class Admin extends User
{
    public function __construct($userId, $username, $passwordHash, $email, $pdo)
    {
        parent::__construct($userId, $username, $passwordHash, 'admin', $pdo);

    }

    // Method to fetch all admins from the database

    public function getAllAdmins()
    {
        try {
            // Modify the SQL query to select users with role 'admin'
            $sql = "SELECT * FROM User WHERE role = 'admin'";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log or handle the error
            error_log("Error fetching admins: " . $e->getMessage());
            return []; // Return an empty array on error
        }
    }


    // Method to update inventory page
    public function updateInventoryPage($pageId, $newContent)
    {
        try {
            // Prepare SQL statement
            $sql = "UPDATE inventory_pages SET content = ? WHERE page_id = ?";
            $stmt = $this->pdo->prepare($sql);

            // Execute the statement
            $success = $stmt->execute([$newContent, $pageId]);

            if ($success && $stmt->rowCount() > 0) {
                return true; // Page updated successfully
            } else {
                return false; // No rows were updated
            }
        } catch (PDOException $e) {
            // Log the error message
            error_log("Error updating inventory page: " . $e->getMessage(), 0);
            return false; // Error occurred
        }
    }


    // Method to add new stock
    public function addNewStock($productName, $quantity, $totalProductsAvailable)
    {
        try {
            $sql = "INSERT INTO Orders (order_date, product_name, quantity, total_products_available) VALUES (CURRENT_TIMESTAMP, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$productName, $quantity, $totalProductsAvailable]);

            return true; // Order added successfully
        } catch (PDOException $e) {
            // Log or handle the error
            error_log("Error adding new order: " . $e->getMessage());
            return false;
        }
    }

    // Method to handle low stock situations
    public function handleLowStock($adminId)
    {
        try {
            // Query the database to identify products with low stock
            $sql = "SELECT product_name, SUM(quantity) AS total_quantity FROM Orders GROUP BY product_name HAVING total_quantity < ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([5]); // Threshold quantity

            $lowStockProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Logic to handle low stock situations
            if (!empty($lowStockProducts)) {
                // Send alert
                $adminEmail = 'B00155926@mytudublin.com';
                $subject = "Low Stock Alert";
                $message = "Some products are running low on stock. Please reorder.\n\n";

                foreach ($lowStockProducts as $product) {
                    $message .= "Product: " . $product['product_name'] . ", Total Quantity: " . $product['total_quantity'] . "\n";
                }

                // Check if the mail function was successful
                if (mail($adminEmail, $subject, $message)) {
                    return true; // Successfully sent alert
                } else {
                    throw new Exception("Failed to send email."); // Throw an exception if email sending fails
                }
            } else {
                // No products with low stock found
                return false;
            }
        } catch (PDOException $e) {
            // Handle the database error
            error_log("Error handling low stock: " . $e->getMessage());
            return false; // Error occurred
        } catch (Exception $ex) {
            // Handle the email sending error
            error_log("Error sending email: " . $ex->getMessage());
            return false; // Error occurred
        }
    }

    // Method to fetch all products
    public function getAllProducts()
    {
        try {
            $sql = "SELECT * FROM products";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log or handle the error
            error_log("Error fetching products: " . $e->getMessage());
            return [];
        }
    }
}
?>
