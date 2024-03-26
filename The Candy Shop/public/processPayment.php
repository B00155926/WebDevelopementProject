<?php
/*
processPayment php
*/
?>
<?php
session_start();
require_once '../src/config.php';
require_once '../src/DBconnect.php';
require_once 'common.php';

// Check if the payment method is selected and proceed with registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payment_method'])) {
    $paymentMethod = $_POST['payment_method'];

    // Only register products if payment method is selected
    if ($paymentMethod === 'visa' || $paymentMethod === 'mastercard') {
        // Add products to database if cart is not empty
        if (!empty($_SESSION['cart'])) {
            $sql = "INSERT INTO Product (name, price, description, quantity, total) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            // Loop through each purchased product
            foreach ($_SESSION['cart'] as $product) {
                $name = $product['name'];
                $price = floatval($product['price']);
                $quantity = intval($product['quantity']);

                // Set the initial description to "pending"
                $description = "pending";

                // Perform the multiplication operation
                $total = $price * $quantity;

                // Execute the query
                $stmt->execute([$name, $price, $description, $quantity, $total]);
            }
        }

        // Clear the cart after inserting products into the database
        $_SESSION['cart'] = array();

        // Redirect to the thank you page
        header("Location: thankYou.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Proceed to Payment</title>
    <link rel="stylesheet" href="../css/cart.css">
</head>

<body>

<main>
    <section class="checkout">
        <h2>Proceed to Payment</h2>
        <ul>
            <?php
            // Initialize total price
            $total = 0;

            // Display purchased products and calculate total price
            $total = 0; // Initialize total price
            foreach ($_SESSION['cart'] as $product) {
                // Convert price and quantity to numeric types
                $price = floatval($product['price']);
                $quantity = intval($product['quantity']);

                // Display product details
                echo "<li>{$product['name']} - Quantity: {$product['quantity']} - Price: €{$product['price']} - Total: €" . number_format($price * $quantity, 2) . "</li>";

                // Increment total price
                $total += $price * $quantity;
            }

            ?>
        </ul>
        <p>Total Price: €<?php echo number_format($total, 2); ?></p>
        <div class="payment-options">
            <h3>Select Payment Method:</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label>
                    <input type="radio" name="payment_method" value="visa"> Visa
                </label>
                <label>
                    <input type="radio" name="payment_method" value="mastercard"> Mastercard
                </label>
                <input type="submit" value="Proceed to Payment">
            </form>
        </div>
    </section>
    <div class="back-home">
        <a href="index.php">Back to Home</a>
    </div>
</main>

</body>

</html>
