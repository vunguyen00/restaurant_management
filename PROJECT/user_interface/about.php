<?php 
include ("config/config.php");
session_start();
if (isset($_SESSION['user_name'])) {
    $userName = $_SESSION['user_name'];  // Lấy tên người dùng từ session
} else {
    $userName = "USER"; 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurent</title>
    <link rel="stylesheet" href="aboutcss.css">
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="logo">
            <h1 style="color: #ff9900;">Restaurant</h1>
        </div>
        <div class="nav-links">
            <a href="HomePage.php">HOME</></a>
            <a href="about.php" style="background-color: #ff9900; color: #fff; padding: 10px 15px; border-radius: 4px; text-decoration: none;">ABOUT</a>
            <a href="booking.php">BOOKING</a>
            <a href="history2.php">VIEW BOOKING HISTORY</a>
            <a href="order.php">DISHES</a>
            <a href="../chat.php">CHAT</a>
            <!-- <a href="history.php">BILL</a> -->
            <div class="dropdown">
                <a href="#" class="user-btn"><?php echo htmlspecialchars($userName); ?></a>
                <div class="dropdown-content">
                    <a href="logout.php">Log Out</a>
                    <a href="../information.php">Information</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Content -->
    <div class="header-content">
        <div class="text-content">
            <h1 style="color:aliceblue;">About Our Restaurant</h1>
            <p style="color:aliceblue;">Welcome to HoaVu, where we pride ourselves on serving delicious meals made from the freshest ingredients.</p>
            <p style="color:aliceblue;">Our restaurant is more than just a place to eat, it's a place where you can relax, enjoy a fine dining experience, and create memories with your loved ones.</p>
            <p style="color:aliceblue;">Since 2024, we have been dedicated to offering our guests the highest quality food and exceptional service. We strive to maintain the perfect balance between traditional flavors and modern cooking techniques.</p>
        </div>
        <div class="image-content">
            <img src="images/da2.jpg" alt="Grilled Food" style="max-width: 90%; border-radius: 10px;">
        </div>
    </div>

    <div class="vision-mission">
        <h2 style="color:aliceblue;">Our Vision</h2>
        <p style="color:aliceblue;">To be the restaurant of choice for people who seek a memorable culinary experience.</p>

        <h2 style="color:aliceblue;">Our Mission</h2>
        <p style="color:aliceblue;">To serve quality dishes prepared with passion and to provide a welcoming environment where customers feel at home.</p>
    </div>

    <!-- Image Section -->
    <div class="about-images">
        <img src="images/da3.jpg" alt="Restaurant Interior">
        <img src="images/da4.jpg" alt="Our Chef">
        <img src="images/da5.jpg" alt="Signature Dish">
    </div>

</body>
</html>