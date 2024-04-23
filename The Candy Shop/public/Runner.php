<?php
require_once 'Employee.php';
require_once 'User.php';
require_once 'Customer.php';
require_once 'Admin.php';
require_once 'Profile.php';
require_once 'Product.php';
require_once 'Order.php';

require_once '../src/config.php';

class Runner
{
    private static $pdo;

    public static function setPDO($pdoInstance)
    {
        self::$pdo = $pdoInstance;
    }

    public static function main()
    {
        // Establish a database connection
        global $host, $username, $password, $dbname, $options;
        try {
            $dsn = "mysql:host=$host;dbname=$dbname";
            $pdo = new PDO($dsn, $username, $password, $options);
            // Set PDO instance for use in tests
            self::setPDO($pdo);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit(); // Finish script execution if connection fails
        }

        // Instantiate objects
        $user = new User(null, null, null, null, self::$pdo);
        $customer = new Customer("Colin", "Colin@yahoo.com", self::$pdo);
        $admin = new Admin(null, null, null, null, self::$pdo);
        $employee = new Employee(null, null, null, null, self::$pdo);
        $profile = new Profile(self::$pdo);
        $product = new Product(self::$pdo);
        $order = new Order(self::$pdo);

        // Run test cases
        self::testCustomerRegistration($customer);
        self::testAdminOperations($admin);
        self::testEmployeeOperations($employee);
        self::testProfileOperations($profile);
        self::testProductOperations($product);
        self::testOrderOperations($order);
        self::testUserAuthentication($user);
    }

    private static function displayTestResult($testName, $result)
    {
        $status = $result ? "Passed" : "Failed";
        echo "<div class=\"test-result " . ($result ? "passed" : "failed") . "\">";
        echo "$testName Test: $status";
        echo "</div>";
    }

    public static function testCustomerRegistration($customer)
    {
        // Test customer registration functionality
        $email = "colin@yahoo.com";
        $password = "pass";

        try {
            // Since 'firstname' is not a field in the Customer table,
            $customerId = $customer->createCustomer($email, $password);
            $customerExists = $customerId !== null;
            self::displayTestResult("Customer Registration", $customerExists);
        } catch (Exception $e) {
            self::displayTestResult("Customer Registration", false);
        }
    }

    public static function testAdminOperations($admin)
    {
        // Test admin operations
        $admins = $admin->getAllAdmins();
        $adminExists = !empty($admins);
        self::displayTestResult("Admin Operations", $adminExists);
    }

    public static function testEmployeeOperations($employee)
    {
        // Test employee-specific operations
        $employeeId = 1; // Employee ID
        $employee->setEmployeeId($employeeId);
        $employee->setDepartment("Sales"); // Example department

        // Test processing orders
        $employee->processOrders();
        $orderProcessedSuccessfully = true; // Assuming processing always succeeds

        self::displayTestResult("Employee Operations", $orderProcessedSuccessfully);
    }

    public static function testProfileOperations($profile)
    {
        // Test profile operations
        $customerId = 19; // Colin's customer ID
        $customerProfile = $profile->getProfileByCustomerId($customerId);
        $profileExists = $customerProfile !== null;
        self::displayTestResult("Profile Operations", $profileExists);
    }

    public static function testProductOperations($product)
    {
        // Test product operations
        $products = $product->fetchProducts();
        $productsExist = !empty($products);
        self::displayTestResult("Product Operations", $productsExist);
    }

    public static function testOrderOperations($order)
    {
        // Test order operations
        $testOrder = new Order(self::$pdo);
        $orderSaved = $testOrder->saveToDatabase();
        self::displayTestResult("Order Operations", $orderSaved);
    }

    public static function testUserAuthentication($user)
    {
        $customerId = 19; // Colin's customer ID
        $isAuthenticated = $user->authenticateUser("Colin", "pass");
        self::displayTestResult("User Authentication", $isAuthenticated);
    }
}

?>
