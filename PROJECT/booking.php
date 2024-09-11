<?php 
include("config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran - Book A Table</title>
    <link rel="stylesheet" href="booking.css">
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
            <a href="#">BOOKING</a>
            <a href="order.php">ORDER</a>
            <a href="cart.php">CART</a>
            <a href="#">USER</a>
        </div>
    </div>

    <!-- Header Content -->
    <div class="header-content">
        <div class="image-content">
            <img src="images/da1.jpg" alt="Restaurant Interior">
            <button class="play-button"></button>
        </div>
        <div class="form-container">
            <h1>Reservation</h1>
            <h2>Book A Table Online</h2>
            <form action="booking.php" method="post">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" required>

                <label for="date">Date & Time</label>
                <input type="datetime-local" id="date" name="date" required>

                <label for="people">No Of People</label>
                <select id="people" name="people">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>

                <label for="request">Special Request</label>
                <textarea id="request" name="request" rows="3"></textarea>

                <button type="submit" class="btn">BOOK NOW</button>
            </form>
        </div>
    </div>

</body>
</html>
