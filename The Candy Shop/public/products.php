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
        <h2>Our Products</h2>
        <div class="category-wrapper" >
            <?php
            // Define the array of products
            $products = array(
                array("Chocolate Bar", 2.00, "../Images/choc.jpg", 10),
                array("Gummy Bears", 5.00, "../Images/gumie.jpg", 20),
                array("Lollipop", 2.00, "../Images/loly.jpg", 15),
                array("Stick of Rock", 5.00, "../Images/rock.jpg", 8),
                array("Chewy Candy", 5.00, "../Images/boiledProd.jpg", 12)
            );

            foreach ($products as $product) {
                echo "<div class='category'>";
                echo "<a href='cart.php'>";
                echo "<img src='" . $product[2] . "' alt='" . $product[0] . "'>";
                echo "<h3>" . $product[0] . "</h3>";
                echo "<p>Price: €" . number_format($product[1], 2) . "</p>";
                // Add to Cart Form
                echo "<form action='cart.php' method='post'>";
                echo "<input type='hidden' name='product_id' value='" . $product[3] . "'>";
                echo "<input type='hidden' name='product_name' value='" . $product[0] . "'>";
                echo "<input type='hidden' name='product_price' value='" . $product[1] . "'>";
                echo "<label for='quantity'>Quantity:</label>";
                echo "<input type='number' id='quantity-" . $product[3] . "' name='quantity[" . $product[3] . "]' value='1' min='1'>";
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
