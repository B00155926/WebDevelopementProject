    <?php
    session_start();

    // Function to update cart
    function updateCart($productId, $quantity, &$cart) {
    foreach ($cart as &$item) {
    if ($item['id'] == $productId) {
    $item['quantity'] = $quantity;
    }
    }
    }

    // Function to add item to cart
    function addToCart($productId, $productName, $productPrice, $productQuantity, &$cart) {
    $productFound = false;
    foreach ($cart as &$item) {
    if ($item['id'] == $productId) {
    $item['quantity'] += $productQuantity;
    $productFound = true;
    break;
    }
    }
    if (!$productFound) {
    $cart[] = array(
    'id' => $productId,
    'name' => $productName,
    'price' => $productPrice,
    'quantity' => $productQuantity
    );
    }
    }

    // Validate and sanitise input
    function validateAndSanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
    }

    // Add to Cart Logic for Products Page
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product_name'], $_POST['product_price'], $_POST['quantity'], $_POST['product_id'])) {
    $productName = validateAndSanitizeInput($_POST['product_name']);
    $productPrice = validateAndSanitizeInput($_POST['product_price']);
    $productQuantity = intval($_POST['quantity']);
    $productId = intval($_POST['product_id']);

    // Ensure price and quantity are valid numbers
    if ($productQuantity <= 0) {
    // Handle invalid quantity
    $errorMessage = "Invalid quantity. Please enter a valid quantity.";
    } else {
    // If cart is empty, initialise it
    if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
    }

    // Add to cart based on product category
    switch ($productId) {
    case 1: // Occasions
    addToCart($productId, $productName, $productPrice, $productQuantity, $_SESSION['cart']);
    break;
    case 6: // Popular Brands
    addToCart($productId, $productName, $productPrice, $productQuantity, $_SESSION['cart']);
    break;
    case 12: // American Selection
    addToCart($productId, $productName, $productPrice, $productQuantity, $_SESSION['cart']);
    break;
    default: // Generic Products
    addToCart($productId, $productName, $productPrice, $productQuantity, $_SESSION['cart']);
    break;
    }
    }
    } else {
    // Handle missing fields
    $errorMessage = "Please fill in all the required fields.";
    }
    }

    // Update Cart Logic for Products Page
    if (isset($_POST['update_cart'])) {
        if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {
            foreach ($_POST['quantity'] as $productId => $quantity) {
                $productId = intval($productId);
                $quantity = intval($quantity);
                updateCart($productId, $quantity, $_SESSION['cart']);
            }
        }
    }

    // Remove from Cart Logic for Products Page
    if (isset($_GET['remove']) && $_GET['remove'] == true && isset($_GET['id'])) {
        $removeId = intval($_GET['id']);
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $removeId) {
                unset($_SESSION['cart'][$key]);
                break;
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

    <?php if (isset($errorMessage)): ?>
        <p><?php echo $errorMessage; ?></p>
    <?php endif; ?>

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
                    $quantity = (int)$item['quantity'];

                    // Perform multiplication after ensuring both operands are numbers
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
            <p>Total Price: €<?php echo number_format($totalPrice, 2); ?></p>
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
