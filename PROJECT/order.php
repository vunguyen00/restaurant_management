<?php 
include("config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran - Cart</title>
    <link rel="stylesheet" href="order.css">
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
    <div class="container">
        <div class="item">
            <img src="chicken-wings.jpg" alt="Chicken Wings">
            <h3>chicken wings <span class="price">$10</span></h3>
            <p>Energistically recapitalize prospective manufactured</p>
            <button>ORDER</button>
        </div>
        <div class="item">
            <img src="steak.jpg" alt="Steak">
            <h3>steak <span class="price">$30</span></h3>
            <p>Continually reintermediate wireless vortals through</p>
            <button>ORDER</button>
        </div>
    </div>
    
    <div class="container">
        <div class="item">
            <img src="pizza.jpg" alt="Pizza">
            <h3>pizza <span class="price">$20</span></h3>
            <p>Holistically simplify superior meta-services for</p>
            <button>ORDER</button>
        </div>
    </div>

    <!-- Back to Top -->
    <a href="#" class="back-to-top">↑</a>

</body>
</html>
