<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link rel="stylesheet" href="../css/CandyShop.css">
</head>
<body>


<div class="menu" id="sticky">
    <ul class="menu-ul">
        <a href="../public/index.php" class="a-menu"><li>Home</li></a>
        <a href="../public/products.php" class="a-menu"><li>Products</li></a>
        <a href="../public/occasions.php" class="a-menu"><li>Occasions</li></a>
        <a href="../public/popularBrands.php" class="a-menu"><li>Popular Brands</li></a>
        <a href="../public/american.php" class="a-menu"><li>American</li></a>
        <a href="../public/aboutUs.php" class="a-menu"><li>About Us</li></a>
        <a href="../public/logIn.php" class="a-menu"><li>LOG IN</li></a>
        <a href="../public/register.php" class="a-menu"><li>Register</li></a>

    </ul>
    <div class="search-box">
        <form method="GET" action="../public/search.php">
            <input type="text" placeholder="Search..." name="search" class="search-input"/>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>

    <div class="parallax" style="height: 38%;">
        <div class="page-title" >The Candy Shop</div>
    </div>
