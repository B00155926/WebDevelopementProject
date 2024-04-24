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
        <h2>Make your day special!</h2>
        <div class="category-wrapper" >
            <?php
            //define array of occasions
            $occasions = array(
                array("Christening", 50.00, "../Images/christening.jpg", 1),
                array("Birthday", 60.00, "../Images/birthday.jpg", 2),
                array("First Communion", 70.00, "../Images/communion.jpg", 3),
                array("Confirmation", 80.00, "../Images/confirmation.jpg", 4),
                array("Wedding", 90.00, "../Images/wedding.jpg", 5)
            );

            foreach ($occasions as $occasion) {
                echo "<div class='category'>";
                echo "<a href='cart.php'>";
                echo "<img src='" . $occasion[2] . "' alt='" . $occasion[0] . "'>";
                echo "<h3>" . $occasion[0] . "</h3>";

                // Extract numeric part from the price string and validate it
                $price = (float) filter_var($occasion[1], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                if (is_numeric($price) && $price > 0) {
                    // Format the price as a number with two decimal places
                    echo "<p>Price: €" . number_format($price, 2) . "</p>";

                    // Add to Cart Form
                    echo "<form action='cart.php' method='post'>";
                    echo "<input type='hidden' name='product_id' value='" . $occasion[3] . "'>";
                    echo "<input type='hidden' name='product_name' value='" . $occasion[0] . "'>";
                    echo "<input type='hidden' name='product_price' value='" . $occasion[1] . "'>";
                    echo "<label for='quantity'>Quantity:</label>";
                    echo "<input type='number' id='quantity-" . $occasion[3] . "' name='quantity[" . $occasion[3] . "]' value='1' min='1'>";
                    echo "<button type='submit'>Add to Cart</button>";
                    echo "</form>";
                } else {
                    echo "<p>Invalid price</p>";
                }

                echo "</div>";
            }
            ?>

        </div>
    </section>

</main>

<?php require "../templates/footer.php"; ?>

</body>
</html>
