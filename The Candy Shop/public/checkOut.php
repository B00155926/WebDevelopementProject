<?php
session_start();

// Function to calculate total price
function calculateTotalPrice($cartItems) {
    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $price = floatval($item['price']);
        $quantity = intval($item['quantity']);
        if (is_numeric($price) && is_numeric($quantity)) {
            $totalPrice += $price * $quantity;
        } else {
            // set price and quantity to 0 and continue calculation
            $price = 0;
            $quantity = 0;
            // Inform the user about the issue
            echo "<p>Invalid price or quantity for product: " . htmlspecialchars($item['name']) . "</p>";
        }
    }
    return $totalPrice;
}

// Calculate total price
$totalPrice = isset($_SESSION['cart']) ? calculateTotalPrice($_SESSION['cart']) : 0;
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/cart.css">
</head>
<body>

<main>
    <section class="checkout">
        <h2>Checkout</h2>
        <ul class="cart-list">
            <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                <?php foreach ($_SESSION['cart'] as $product): ?>
                    <li><?php echo htmlspecialchars($product['name']); ?> - Quantity: <?php echo intval($product['quantity']); ?> - €<?php echo number_format(floatval($product['price']), 2); ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Your cart is empty.</li>
            <?php endif; ?>
        </ul>
        <p>Total Price: €<?php echo number_format($totalPrice, 2); ?></p>
        <div class="payment-options">
            <h3>What would you like to do?</h3>
            <a href="logIn.php">LOG IN</a>
            <h3>OR</h3>
            <a href="index.php" >Add More Products</a>
            <?php if ($totalPrice > 0): ?>
                <a href="processPayment.php">Proceed to Payment</a>
            <?php else: ?>
                <p>Please add items to your cart to proceed to payment.</p>
            <?php endif; ?>
        </div>

    </section>
</main>
</body>
</html>
