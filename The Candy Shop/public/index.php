<?php
/*
HOMEPAGE index php
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nav Bar</title>
    <link rel="stylesheet" href="../css/products.css">
</head>
<body>
<?php require "../templates/navBar.php"; ?>

<main>

    <section class="top-categories">
        <h2>Top Categories</h2>
        <div class="category-wrapper">
            <?php
            $categories = array(
                array("Bars", "Selection of Chocolate Bars", "../Images/bars.jpg", "products.php"),
                array("Jellies", "Selection of Jellies", "../Images/jellies.jpg", "american.php"),
                array("Lollipops", "Selection of Lollipops", "../Images/lol.jpg", "products.php"),
                array("Chew Sweets", "Selection of Chew Sweets", "../Images/chew.jpg", "american.php"),
                array("Boiled Sweets", "Selection of Boiled Sweets", "../Images/boiled.jpg", "popularBrands.php")
            );

            foreach ($categories as $category) {
                echo "<div class='category'>";
                echo "<a href='" . $category[3] . "'>";
                echo "<img src='" . $category[2] . "' alt='" . $category[0] . "'>";
                echo "</a>";
                echo "<h3>" . $category[0] . "</h3>";
                echo "<p>" . $category[1] . "</p>";
                echo "</div>";
            }
            ?>
        </div>
    </section>

</main>

<?php require "../templates/footer.php"; ?>

</body>

</html>
