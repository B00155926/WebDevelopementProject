<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="../css/search.css">
</head>

    <iframe width="100%" height="300" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/255894115&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"></iframe><div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="https://soundcloud.com/50_cent" title="50 Cent" target="_blank" style="color: #cccccc; text-decoration: none;">50 Cent</a> · <a href="https://soundcloud.com/50_cent/candy-shop-album-version" title="Candy Shop (feat. Olivia)" target="_blank" style="color: #cccccc; text-decoration: none;">Candy Shop (feat. Olivia)</a></div>

<body>
<div class="product-container">
    <?php
    // Include Product class
    require_once 'Product.php';

    // Define the array of products
    $products = array(
        array("Chocolate Bar", 2.00, "../Images/choc.jpg", 10),
        array("Gummy Bears", 5.00, "../Images/gumie.jpg", 20),
        array("Lollipop", 2.00, "../Images/loly.jpg", 15),
        array("Stick of Rock", 5.00, "../Images/rock.jpg", 8),
        array("Chewy Candy", 5.00, "../Images/boiledProd.jpg", 12)
    );

    $occasions = array(
        array("Christening", 50.00, "../Images/christening.jpg", 1),
        array("Birthday", 60.00, "../Images/birthday.jpg", 2),
        array("First Communion", 70.00, "../Images/communion.jpg", 3),
        array("Confirmation", 80.00, "../Images/confirmation.jpg", 4),
        array("Wedding", 90.00, "../Images/wedding.jpg", 5)
    );

    $populars = array(
        array("Haribo", 5.00, "../Images/haribo.jpg", 6),
        array("Drumsticks", 5.00, "../Images/drumstick.jpg", 7),
        array("Skittles", 5.00, "../Images/skittles.jpg", 18),
        array("M & M", 5.00, "../Images/mandm.jpg", 9),
        array("Kinder Bueno", 5.00, "../Images/kinder.jpg", 11)
    );

    $americans = array(
        array("Airheads", 2.00, "../Images/airheads.jpg", 12),
        array("Twizzlers", 2.00, "../Images/twizzlers.jpg", 13),
        array("Nerds", 2.00, "../Images/nerds.jpg", 14),
        array("PayDay", 2.00, "../Images/payday.jpg", 19),
        array("Prime", 5.00, "../Images/prime.jpg", 16)
    );

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
