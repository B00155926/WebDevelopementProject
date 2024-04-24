<?php
/*
Employee class
*/
?>

<?php
require_once 'User.php';

class Employee extends User {
    protected $employeeId;
    protected $department;

    public function __construct($userId, $username, $passwordHash, $email, $pdo)
    {
        parent::__construct($userId, $username, $passwordHash, 'employee', $pdo);

    }


    // Getter and setter methods for employee-specific properties
    public function getEmployeeId() {
        return $this->employeeId;
    }

    public function getDepartment() {
        return $this->department;
    }

    public function setEmployeeId($employeeId) {
        $this->employeeId = $employeeId;
    }

    public function setDepartment($department) {
        $this->department = $department;
    }
    // Method to process orders
    public function processOrders() {
        try {
            // Update order status in the Product table
            $sql = "UPDATE Product SET status = 'Processed' WHERE status = 'Pending'";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            echo "Orders processed successfully.";
        } catch (PDOException $e) {
            echo "Error processing orders: " . $e->getMessage();
        }
    }


}
?>