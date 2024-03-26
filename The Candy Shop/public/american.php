<?php
/*
products php
*/
?>
<?php
session_start();
require "Product.php";
require "../src/config.php";
require "../src/DBconnect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our Products</title>
    <link rel="stylesheet" href="../css/products.css">

</head>
<body>

<?php require "../templates/navBar.php"; ?>

<main>

    <section class="top-categories">
        <h2>The American Selection!</h2>
        <div class="category-wrapper" >
            <?php
            $americans = Product::getAmericanData();

            foreach ($americans as $american) {
                echo "<div class='category'>";
                echo "<img src='" . $american[2] . "' alt='" . $american[0] . "'>";
                echo "<h3>" . $american[0] . "</h3>";
                echo "<p>Price: €" . number_format($american[1], 2) . "</p>";
                // Add to Cart Form
                echo "<form action='cart.php' method='post'>";
                echo "<input type='hidden' name='product_id' value='" . $american[3] . "'>";
                echo "<input type='hidden' name='product_name' value='" . $american[0] . "'>";
                echo "<input type='hidden' name='product_price' value='" . $american[1] . "'>";
                echo "<label for='quantity'>Quantity:</label>";
                echo "<input type='number' id='quantity-" . $american[3] . "' name='quantity[" . $american[3] . "]' value='1' min='1'>";

                echo "<button type='submit'>Add to Cart</button>";
                echo "</form>";
                echo "</div>";
            }
            ?>
        </div>
    </section>

</main>

<?php require "../templates/footer.php"; ?>

</body>
</html>
