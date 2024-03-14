<?php
/*
checkOut php
*/
?>

<?php
session_start();

// Calculate total price
$totalPrice = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product) {
        // Convert price and quantity to numeric types
        $price = floatval($product['price']);
        $quantity = intval($product['quantity']);

        // Ensure both price and quantity are numeric before adding to total price
        if (is_numeric($price) && is_numeric($quantity)) {
            $totalPrice += $price * $quantity;
        } else {
        }
    }
}

// Check if the cart array exists in the session
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action === "Add More Products") {
        // Redirect to the index page
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/checkOut.css">
</head>

<body>

<main>
    <section class="checkout">
        <h2>Checkout</h2>
        <ul class="cart-list">
            <?php
            // Display products in the shopping cart
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $product) {
                    echo "<li>{$product['name']} - Quantity: {$product['quantity']} - €{$product['price']}</li>";
                }
            } else {
                echo "<li>Your cart is empty.</li>";
            }
            ?>
        </ul>
        <p>Total Price: €<?php echo number_format($totalPrice, 2); ?></p>
        <div class="payment-options">
            <h3>What would you like to do?</h3>
            <a href="logIn.php">LOG IN</a>
            <h3>OR</h3>
            <a href="index.php">Add More Products</a>
            <a href="processPayment.php">Proceed to Payment</a>
        </div>
    </section>
</main>

<?php require "../templates/footer.php"; ?>

</body>

</html>
