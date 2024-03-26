<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="../css/search.css">
</head>
<body>
<div class="product-container">
    <?php
    // Include Product class
    require_once 'Product.php';

    // Get product data for different categories
    $products = Product::getProductData();
    $occasions = Product::getOccasionsData();
    $populars = Product::getPopularData();
    $americans = Product::getAmericanData();

    // Display products for each category
    displayProducts($products, "Products");
    displayProducts($occasions, "Occasions");
    displayProducts($populars, "Popular Brands");
    displayProducts($americans, "American Sweets");

    // Function to display products for a category
    function displayProducts($category, $title) {
        echo "<h2>$title</h2>";
        echo "<div class='product-container'>";
        foreach ($category as $product) {
            displayProduct($product);
        }
        echo "</div>";
    }

    // Function to display a product
    function displayProduct($product) {
        $name = $product[0];
        $price = $product[1];
        $image = $product[2];
        $quantity = $product[3];

        // Display the product information
        echo "<div class='product'>";
        echo "<img src='$image' alt='$name'>";
        echo "<h3>$name</h3>";
        echo "<p>Price: €" . number_format($price, 2) . "</p>";
        echo "<p>Quantity: $quantity</p>";
        echo "<button>Add to Cart</button>";
        echo "</div>";
    }
    ?>
</div>
<!-- Back to Home button -->
<div class="back-home">
    <a href="index.php">Back to Home</a>
</div>

</body>
</html>
