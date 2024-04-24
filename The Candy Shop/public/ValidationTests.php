<?php

class ValidationTests
{
    public static function testFirstName($firstName)
    {
        // Validate first name
        if (empty($firstName)) {
            return false; // Validation failed
        } elseif (!preg_match("/^[a-zA-Z'-]+$/", $firstName)) {
            return false; // Validation failed
        }
        return true; // Validation passed
    }

    public static function testLastName($lastName)
    {
        // Validate last name
        if (empty($lastName)) {
            return false; // Validation failed
        } elseif (!preg_match("/^[a-zA-Z'-]+$/", $lastName)) {
            return false; // Validation failed
        }
        return true; // Validation passed
    }

    public static function testEmail($email)
    {
        // Validate email
        if (empty($email)) {
            return false; // Validation failed
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false; // Validation failed
        }
        return true; // Validation passed
    }

    public static function testTelephone($telephone)
    {
        // Validate telephone
        if (empty($telephone)) {
            return false; // Validation failed
        } elseif (!preg_match("/^[0-9]+$/", $telephone)) {
            return false; // Validation failed
        }
        return true; // Validation passed
    }
}

?>
