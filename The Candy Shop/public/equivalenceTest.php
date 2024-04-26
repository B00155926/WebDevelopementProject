<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Runner</title>
    <link rel="stylesheet" href="../css/validation.css">
</head>
<body>

<div class="container">
    <h1>Equivalence Test</h1>
    <?php
    require "../src/config.php";
    require "../src/DBconnect.php";
    // Define additional test cases with comments specifying what each test is doing
    $additionalTestCases = array(
        // Test cases for invalid input data
        // Test case 1: Empty first name
        array(
            "description" => "Empty first name",
            "firstname" => "",
            "lastname" => "Doe",
            "email" => "john@example.com",
            "telephone" => "1234567890",
            "username" => "john_doe123",
            "password" => "Strong@Password123",
            "role" => "customer"
        ),
        // Test case 2: Empty last name
        array(
            "description" => "Empty last name",
            "firstname" => "John",
            "lastname" => "",
            "email" => "john@example.com",
            "telephone" => "1234567890",
            "username" => "john_doe123",
            "password" => "Strong@Password123",
            "role" => "customer"
        ),
        // Test case 3: Invalid email format
        array(
            "description" => "Invalid email format",
            "firstname" => "John",
            "lastname" => "Doe",
            "email" => "invalid_email",
            "telephone" => "1234567890",
            "username" => "john_doe123",
            "password" => "Strong@Password123",
            "role" => "customer"
        ),
        // Test case 4: Invalid first name (contains non-alphabetic characters)
        array(
            "description" => "Invalid first name (contains non-alphabetic characters)",
            "firstname" => "John1",
            "lastname" => "Doe",
            "email" => "john@example.com",
            "telephone" => "1234567890",
            "username" => "john_doe123",
            "password" => "Strong@Password123",
            "role" => "customer"
        ),
        // Test case 5: Valid last name
        array(
            "description" => "Valid last name",
            "firstname" => "John",
            "lastname" => "Doe",
            "email" => "john@example.com",
            "telephone" => "1234567890",
            "username" => "john_doe123",
            "password" => "Strong@Password123",
            "role" => "customer"
        ),
        // Test case 6: Valid email format
        array(
            "description" => "Valid email format",
            "firstname" => "John",
            "lastname" => "Doe",
            "email" => "john@example.com",
            "telephone" => "1234567890",
            "username" => "john_doe123",
            "password" => "Strong@Password123",
            "role" => "customer"
        ),
        // Test case 7: Valid telephone number (10 digits)
        array(
            "description" => "Valid telephone number (10 digits)",
            "firstname" => "John",
            "lastname" => "Doe",
            "email" => "john@example.com",
            "telephone" => "1234567890",
            "username" => "john_doe123",
            "password" => "Strong@Password123",
            "role" => "customer"
        ),
        // Test case 8: Invalid telephone number (not 10 digits)
        array(
            "description" => "Invalid telephone number (not 10 digits)",
            "firstname" => "John",
            "lastname" => "Doe",
            "email" => "john@example.com",
            "telephone" => "1234567", // Not 10 digits
            "username" => "john_doe123",
            "password" => "Strong@Password123",
            "role" => "customer"
        ),
        // Test case 9: Valid username (alphanumeric, 5 to 20 characters)
        array(
            "description" => "Valid username (alphanumeric, 5 to 20 characters)",
            "firstname" => "John",
            "lastname" => "Doe",
            "email" => "john@example.com",
            "telephone" => "1234567890",
            "username" => "john_doe123",
            "password" => "Strong@Password123",
            "role" => "customer"
        ),
        // Test case 10: Invalid username (less than 5 characters)
        array(
            "description" => "Invalid username (less than 5 characters)",
            "firstname" => "John",
            "lastname" => "Doe",
            "email" => "john@example.com",
            "telephone" => "1234567890",
            "username" => "joh", // Less than 5 characters
            "password" => "Strong@Password123",
            "role" => "customer"
        ),
        // Test case 11: Invalid username (greater than 20 characters)
        array(
            "description" => "Invalid username (greater than 20 characters)",
            "firstname" => "John",
            "lastname" => "Doe",
            "email" => "john@example.com",
            "telephone" => "1234567890",
            "username" => "john_doe12345678901234567890", // Greater than 20 characters
            "password" => "Strong@Password123",
            "role" => "customer"
        ),
        // Test case 12: Invalid username (contains special characters)
        array(
            "description" => "Invalid username (contains special characters)",
            "firstname" => "John",
            "lastname" => "Doe",
            "email" => "john@example.com",
            "telephone" => "1234567890",
            "username" => "john_doe!@#", // Contains special characters
            "password" => "Strong@Password123",
            "role" => "customer"
        ),
        // Test case 13: Valid password (meets complexity requirements)
        array(
            "description" => "Valid password (meets complexity requirements)",
            "firstname" => "John",
            "lastname" => "Doe",
            "email" => "john@example.com",
            "telephone" => "1234567890",
            "username" => "john_doe123",
            "password" => "Strong@Password123",
            "role" => "customer"
        ),
        // Test case 14: Invalid password (does not meet complexity requirements)
        array(
            "description" => "Invalid password (does not meet complexity requirements)",
            "firstname" => "John",
            "lastname" => "Doe",
            "email" => "john@example.com",
            "telephone" => "1234567890",
            "username" => "john_doe123",
            "password" => "password", // Does not meet complexity requirements
            "role" => "customer"
        ),
        // Test case 15: Valid role (customer)
        array(
            "description" => "Valid role (customer)",
            "firstname" => "John",
            "lastname" => "Doe",
            "email" => "john@example.com",
            "telephone" => "1234567890",
            "username" => "john_doe123",
            "password" => "Strong@Password123",
            "role" => "customer"
        ),
        // Test case 16: Valid role (admin)
        array(
            "description" => "Valid role (admin)",
            "firstname" => "John",
            "lastname" => "Doe",
            "email" => "john@example.com",
            "telephone" => "1234567890",
            "username" => "john_doe123",
            "password" => "Strong@Password123",
            "role" => "admin"
        ),
        // Test case 17: Valid role (employee)
        array(
            "description" => "Valid role (employee)",
            "firstname" => "John",
            "lastname" => "Doe",
            "email" => "john@example.com",
            "telephone" => "1234567890",
            "username" => "john_doe123",
            "password" => "Strong@Password123",
            "role" => "employee"
        ),
        // Test case 18: Invalid role (other than customer, admin, or employee)
        array(
            "description" => "Invalid role (other than customer, admin, or employee)",
            "firstname" => "John",
            "lastname" => "Doe",
            "email" => "john@example.com",
            "telephone" => "1234567890",
            "username" => "john_doe123",
            "password" => "Strong@Password123",
            "role" => "guest" // Invalid role
        )
    );

    // Initialise test cases array
    $testCases = [];

    // Run all test cases
    foreach ($additionalTestCases as $index => $testCase) {
        echo "Running Test Case " . ($index + 1) . ": " . $testCase['description'] . "<br>";
        echo "First Name: " . $testCase['firstname'] . ", ";
        echo "Last Name: " . $testCase['lastname'] . ", ";
        echo "Email: " . $testCase['email'] . ", ";
        echo "Telephone: " . $testCase['telephone'] . ", ";
        echo "Username: " . $testCase['username'] . ", ";
        echo "Password: " . $testCase['password'] . ", ";
        echo "Role: " . $testCase['role'] . ", ";
        $result = testRegistration($testCase);
        echo $result ? "Pass" : "Fail";
        echo "<br><br>";
    }

    // Function to simulate registration and return true for success, false for failure
    function testRegistration($data)
    {
        // Simulate POST request to the registration form
        $url = 'http://localhost/The%20Candy%20Shop/public/register.php';
        $postData = http_build_query($data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postData
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        // Check if registration was successful
        return strpos($result, "User registered successfully!") !== false;
    }
    ?>
</div>
</body>
</html>
