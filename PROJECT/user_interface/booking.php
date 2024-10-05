<?php
include 'config/config.php';
session_start(); // Bắt đầu session để sử dụng $_SESSION

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (isset($_SESSION['user_name'])) {
    $userName = $_SESSION['user_name'];  // Lấy tên người dùng từ session
} else {
    $userName = "USER"; 
}

// Truy vấn danh sách bàn từ cơ sở dữ liệu
$sql_tables = "SELECT table_id, table_number FROM restaurant_table WHERE status = 'empty'";
$result_tables = $mysqli->query($sql_tables);  // Kiểm tra kết nối và thực hiện truy vấn
if (!$result_tables) {
    die("Query failed: " . $mysqli->error);  // Hiển thị lỗi nếu truy vấn thất bại
}
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
        <div class="image-content">
            <img src="images/da1.jpg" alt="Restaurant Interior">
            <button class="play-button"></button>
        </div>
        <div class="form-container">
            <h1>Reservation</h1>
            <h2>Book A Table Online</h2>
            <form action="process_booking.php" method="post">
                <!-- Hiển thị tên người dùng (readonly) -->
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userName); ?>" readonly>

                <!-- Thay trường chọn email thành chọn bàn -->
                <label for="table">Choose a Table</label>
                <select id="table" name="table" required>
                    <?php while ($row = $result_tables->fetch_assoc()): ?>
                        <option value="<?php echo $row['table_id']; ?>">Table <?php echo $row['table_number']; ?></option>
                    <?php endwhile; ?>
                </select>

                <!-- Các trường còn lại -->
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

                <!-- Nút BOOK NOW -->
                <button type="submit" class="btn">BOOK NOW</button>
            </form>
        </div>
    </div>

</body>
</html>
