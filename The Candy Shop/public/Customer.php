<?php
/*
Customer class (inheritance)
*/
?>
<?php
require_once 'User.php';
require_once 'Profile.php';

class Customer extends User {
    protected $customerId;
    protected $profile;
    protected $pdo;


    public function __construct($username, $email, $pdo, $customerSpecificParameter = null) {
        parent::__construct(null, $username, null, $email, $pdo);
        // Additional initialisation code specific to Customer class
        $this->pdo = $pdo;
        $this->profile = new Profile($pdo); // Aggregation of the Profile class


    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId) {
        $this->customerId = $customerId;
    }

    public function getProfile() {
        return $this->profile;
    }

    public function setProfile(Profile $profile) {
        $this->profile = $profile;
    }


    // Create a new customer
    public function createCustomer($email, $password) {
        try {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert customer data into the User table without specifying 'firstname'
            $sql = "INSERT INTO User (email, password) VALUES (?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$email, $hashedPassword]);
            $customerId = $this->pdo->lastInsertId();

            // Set the customer's ID
            $this->setCustomerId($customerId);

            return true;
        } catch (PDOException $e) {
            echo "Error creating customer: " . $e->getMessage();
            return false;
        }
    }

    // Retrieve a customer by ID
    public function getCustomerById($customerId) {
        try {
            $sql = "SELECT * FROM User WHERE user_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$customerId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching customer: " . $e->getMessage();
            return false;
        }
    }

    // Update customer's email and password
    public function updateCustomer($customerId, $email, $password) {
        try {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Update customer data in the User table
            $sql = "UPDATE User SET email = ?, password = ? WHERE user_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$email, $hashedPassword, $customerId]);

            return true;
        } catch (PDOException $e) {
            echo "Error updating customer: " . $e->getMessage();
            return false;
        }
    }

    // Delete a customer
    public function deleteCustomer($customerId) {
        try {
            // Delete customer data from the User table
            $sql = "DELETE FROM User WHERE user_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$customerId]);

            return true;
        } catch (PDOException $e) {
            echo "Error deleting customer: " . $e->getMessage();
            return false;
        }
    }
}
?>
