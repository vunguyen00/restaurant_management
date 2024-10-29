<?php
include 'config/config.php';
session_start(); // Bắt đầu session để sử dụng $_SESSION

// Kiểm tra xem người dùng đã đăng nhập hay chưa
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
    <link rel="stylesheet" href="HomePage.css">
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="logo">
            <h1 style="color: #ff9900;">Restaurant</h1>
        </div>
        <div class="nav-links">
            <a href="HomePage.php">HOME</a>
            <a href="about.php">ABOUT</a>
            <a href="booking.php">BOOKING</a>
            <a href="history2.php">VIEW BOOKING HISTORY</a>
            <a href="order.php">ORDER</a>
            <a href="history.php">BILL</a>
            <div class="dropdown">
                <a href="#" class="user-btn"><?php echo htmlspecialchars($userName); ?></a>
                <div class="dropdown-content">
                    <a href="logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Content -->
    <div class="header-content">
        <div class="text-content">
            <h1>Enjoy Our Delicious Meal</h1>
            <p>You want a romantic place to have dinner with delicious food. Come to us. A place where you will not be disappointed</p>
            <a href="#" class="btn">BOOK A TABLE</a>
        </div>
        <div class="image-content">
            <img src="images/da1.jpg" alt="Grilled Food" style="max-width: 100%; border-radius: 10px;">
        </div>
    </div>

</body>
</html>
