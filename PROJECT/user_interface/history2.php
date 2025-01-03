<?php
include 'config/config.php';
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (isset($_SESSION['user_name'])) {
    $userName = $_SESSION['user_name'];  // Lấy tên người dùng từ session
} else {
    $userName = "USER"; 
}

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

// Lấy ID người dùng từ session
$user_id = $_SESSION['user_id'];

// Truy vấn lịch sử đặt bàn của người dùng hiện tại
$sql = "SELECT b.booking_id, t.table_number, b.booking_time, b.special_request
        FROM booking_history b
        JOIN restaurant_table t ON b.table_id = t.table_id
        WHERE b.user_id = ?
        ORDER BY b.booking_time DESC";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <link rel="stylesheet" href="history2.css">
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
            <a href="order.php">DISHES</a>
            <a href="../chat.php">CHAT</a>
            <div class="dropdown">
                <a href="#" class="user-btn"><?php echo htmlspecialchars($userName); ?></a>
                <div class="dropdown-content">
                    <a href="logout.php">Log Out</a>
                    <a href="../information.php">Information</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking History Content -->
    <div class="history-content-a">
       <div class="history-content">
            <h2>Your Booking History</h2>
                
                <?php if ($result->num_rows > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Table Number</th>
                                <th>Booking Time</th>
                                <th>Special Request</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['booking_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['table_number']); ?></td>
                                    <td><?php echo htmlspecialchars($row['booking_time']); ?></td>
                                    <td><?php echo htmlspecialchars($row['special_request']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>You have no booking history.</p>
                <?php endif; ?>
        </div>
    </div>
    

</body>
</html>