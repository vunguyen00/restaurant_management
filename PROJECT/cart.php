<?php 
include("config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran - Cart</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="logo">
            <h1 style="color: #ff9900;">Restaurant</h1>
        </div>
        <div class="nav-links">
            <a href="index.php">HOME</a>
            <a href="#">ABOUT</a>
            <a href="#">SERVICE</a>
            <a href="#">CONTACT</a>
            <a href="booking.php">BOOKING</a>
            <a href="order.php">ORDER</a>
            <a href="cart.php">CART</a>
            <a href="#">USER</a>
        </div>
    </div>

    <!-- Cart Container -->
    <div class="cart-container">
        <h1>Cart</h1>
        <div class="breadcrumb">
            <a href="#" style="color: #ff9900;">HOME</a> / CART
        </div>

        <table class="cart-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><img src="chicken-wings.jpg" alt="Chicken Wings"></td>
                    <td>Chicken Wings</td>
                    <td>$10</td>
                    <td><button class="delete-btn">DELETE</button></td>
                </tr>
                <tr>
                    <td><img src="pizza.jpg" alt="Pizza"></td>
                    <td>Pizza</td>
                    <td>$20</td>
                    <td><button class="delete-btn">DELETE</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Back to Top -->
    <a href="#" class="back-to-top">↑</a>

</body>
</html>
