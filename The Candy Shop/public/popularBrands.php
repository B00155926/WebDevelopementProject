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
        <h2>Check out our Popular Brands!</h2>
        <div class="category-wrapper" >
            <?php
            //Define array of populars brands
            $populars = array(
                array("Haribo", 5.00, "../Images/haribo.jpg", 6),
                array("Drumsticks", 5.00, "../Images/drumstick.jpg", 7),
                array("Skittles", 5.00, "../Images/skittles.jpg", 18),
                array("M & M", 5.00, "../Images/mandm.jpg", 9),
                array("Kinder Bueno", 5.00, "../Images/kinder.jpg", 11)
            );

            foreach ($populars as $popular) {
                echo "<div class='category'>";
                echo "<a href='cart.php'>";
                echo "<img src='" . $popular[2] . "' alt='" . $popular[0] . "'>";
                echo "<h3>" . $popular[0] . "</h3>";
                echo "<p>Price: €" . number_format($popular[1], 2) . "</p>";
                // Add to Cart Form
                echo "<form action='cart.php' method='post'>";
                echo "<input type='hidden' name='product_id' value='" . $popular[3] . "'>";
                echo "<input type='hidden' name='product_name' value='" . $popular[0] . "'>";
                echo "<input type='hidden' name='product_price' value='" . $popular[1] . "'>";
                echo "<label for='quantity'>Quantity:</label>";
                echo "<input type='number' id='quantity-" . $popular[3] . "' name='quantity[" . $popular[3] . "]' value='1' min='1'>";
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
