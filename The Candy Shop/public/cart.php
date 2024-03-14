<?php
/*
cart php
*/
?>

<?php
session_start();

// Function to update cart
function updateCart($productId, $quantity) {
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productId) {
            $item['quantity'] = $quantity;
        }
    }
}

// Add to Cart Logic
if (isset($_POST['product_name']) && isset($_POST['product_price']) && isset($_POST['quantity'])) {
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productQuantity = $_POST['quantity'];
    $productId = $_POST['product_id']; // Assuming product id is included in the form

    // If cart is empty, initialize it
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Check if product is already in cart
    $productFound = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productId) {
            $item['quantity'] += $productQuantity;
            $productFound = true;
        }
    }

    // If product is not in cart, add it
    if (!$productFound) {
        $_SESSION['cart'][] = array(
            'id' => $productId,
            'name' => $productName,
            'price' => $productPrice,
            'quantity' => $productQuantity
        );
    }
}

// Update Cart Logic
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $productId => $quantity) {
        updateCart($productId, $quantity);
    }
}

// Remove from Cart Logic
if (isset($_GET['remove']) && $_GET['remove'] == true && isset($_GET['id'])) {
    $removeId = $_GET['id'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $removeId) {
            unset($_SESSION['cart'][$key]);
            break; // Exit the loop after removing the item
        }
    }
    // Reset array keys after unset
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

// Empty Cart Logic
if (isset($_GET['empty']) && $_GET['empty'] == true) {
    unset($_SESSION['cart']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../css/cart.css">
</head>
<body>

<h2>Shopping Cart</h2>

<?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
    <form action="cart.php" method="post">
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php $totalPrice = 0; ?>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <?php
                // Ensure $item['price'] is converted to a float before multiplication
                $price = (float)$item['price'];
                $quantity = (int)$item['quantity']; // Assuming quantity is an integer

                // Perform multiplication after ensuring both operands are numeric
                $totalPrice += $price * $quantity;
                ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo number_format($price, 2); ?></td>
                    <td>
                        <input type="number" name="quantity[<?php echo $item['id']; ?>]" value="<?php echo $quantity; ?>" min="1">
                    </td>
                    <td><?php echo number_format($price * $quantity, 2); ?></td>
                    <td><a href="cart.php?remove=true&id=<?php echo $item['id']; ?>">Remove</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p>Total Price: €<?php echo number_format($totalPrice, 2); ?></p> <!-- Display total price here -->
        <input type="submit" name="update_cart" value="Update Cart">
        <a href="cart.php?empty=true">Empty Cart</a>
    </form>
<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>


<a href="products.php">Continue shopping</a>
<a href="checkOut.php">Continue to check out</a>
</body>
</html>
