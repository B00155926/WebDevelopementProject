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
    <h1>Validation Testing</h1>
    <?php

    require_once 'ValidationTests.php';

    //validation tests
    $firstName = "John";
    $lastName = "Doe";
    $email = "john.doe@yahoo.com";
    $telephone = "1234567890";

    // Test first name validation
    $firstNameValid = ValidationTests::testFirstName($firstName);
    echo "<div class='" . ($firstNameValid ? "passed" : "failed") . "'>First Name Validation Test: " . ($firstNameValid ? "Passed" : "Failed") . "</div>";

    // Test last name validation
    $lastNameValid = ValidationTests::testLastName($lastName);
    echo "<div class='" . ($lastNameValid ? "passed" : "failed") . "'>Last Name Validation Test: " . ($lastNameValid ? "Passed" : "Failed") . "</div>";

    // Test email validation
    $emailValid = ValidationTests::testEmail($email);
    echo "<div class='" . ($emailValid ? "passed" : "failed") . "'>Email Validation Test: " . ($emailValid ? "Passed" : "Failed") . "</div>";

    // Test telephone validation
    $telephoneValid = ValidationTests::testTelephone($telephone);
    echo "<div class='" . ($telephoneValid ? "passed" : "failed") . "'>Telephone Validation Test: " . ($telephoneValid ? "Passed" : "Failed") . "</div>";

    ?>
</div>
</body>
</html>
