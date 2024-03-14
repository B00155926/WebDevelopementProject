<?php
/*
Admin class (aggregation with user)
*/
?>

<?php
require_once 'User.php';

class Admin
{
    protected $user;
    protected $pdo;

    public function __construct($userId, $username, $password, $email, $pdo)
    {
      // Instantiate User class
        $this->user = new User($userId, $username, $password, $email, $pdo);

        $this->pdo = $pdo;
    }

// Method to fetch all admins from the database
    public function getAllAdmins()
    {
        try {
            $sql = "SELECT * FROM admin";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle database errors here
            return [];
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
            $stmt->execute([$newContent, $pageId]);

            // Check if the update was successful
            if ($stmt->rowCount() > 0) {
                return true; // Page updated successfully
            } else {
                echo "No rows were updated.";
                return false;
            }
        } catch (PDOException $e) {
            echo "Error updating inventory page: " . $e->getMessage();
            error_log("Error updating inventory page: " . $e->getMessage(), 0);
            return false; // Error occurred
        }
    }

// Method to add new stock
    public function addNewStock($adminId, $productId, $productName, $quantity)
    {
        try {
            // Prepare SQL statement
            $sql = "INSERT INTO Admin_Product (admin_id, product_id, product_name, quantity) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);

            // Execute the statement
            $stmt->execute([$adminId, $productId, $productName, $quantity]);

            return true; // Stock added successfully
        } catch (PDOException $e) {
            echo "Error adding new stock: " . $e->getMessage();
            return false; // Error occurred
        }
    }

    // Method to handle low stock situations
    public function handleLowStock($productName)
    {
        try {
            // Query the database to identify products with low stock
            $sql = "SELECT * FROM products WHERE name = ? AND quantity < ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$productName, LOW_STOCK_THRESHOLD]); // Use a predefined threshold for low stock
            $lowStockProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Logic to handle low stock situations
            // For example, trigger notifications or automatically reorder products

            return $lowStockProducts; // Return products with low stock
        } catch (PDOException $e) {
            echo "Error handling low stock: " . $e->getMessage();
            return false; // Error occurred
        }
    }


// Getters and setters for User attributes
    public function getUserId()
    {
        return $this->user->getUserId();
    }

    public function getUsername()
    {
        return $this->user->getUsername();
    }

    public function getPassword()
    {
        return $this->user->getPassword();
    }

    public function getEmail()
    {
        return $this->user->getEmail();
    }

    public function setUserId($userId)
    {
        $this->user->setUserId($userId);
    }

    public function setUsername($username)
    {
        $this->user->setUsername($username);
    }

    public function setPassword($password)
    {
        $this->user->setPassword($password);
    }

    public function setEmail($email)
    {
        $this->user->setEmail($email);
    }
}
