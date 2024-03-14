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

    public function __construct($userId, $username, $passwordHash, $role, $pdo) {
        // Call the parent constructor to set user properties
        parent::__construct($userId, $username, $passwordHash, $role, $pdo);

        // Initialize additional properties specific to Employee
        $this->employeeId = null; // Initialize to null,  will be set later
        $this->department = null; // Initialize to null, will be set later
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

}
?>
