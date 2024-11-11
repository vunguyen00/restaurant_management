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
    <script>
        function validateBooking() {
            const dateInput = document.getElementById('date').value;
            const now = new Date();
            const bookingTime = new Date(dateInput);

            // Kiểm tra nếu thời gian đặt bàn ít nhất 1 giờ sau thời gian hiện tại
            const oneHourLater = new Date(now.getTime() + 60 * 60 * 1000);
            if (bookingTime < oneHourLater) {
                alert('Bạn cần đặt bàn ít nhất 1 giờ sau thời gian hiện tại.');
                return false; // Ngăn không cho gửi biểu mẫu
            }

            // Kiểm tra nếu thời gian đặt bàn sau 5 giờ
            const fiveHoursLater = new Date(now.getTime() + 5 * 60 * 60 * 1000);
            if (bookingTime >= fiveHoursLater) {
                return true; // Cho phép gửi biểu mẫu, bàn nào cũng có thể đặt
            }

            return true; // Cho phép gửi biểu mẫu nếu đặt sau 1 giờ
        }
    </script>
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
        <div class="image-content">
            <img src="images/da1.jpg" alt="Restaurant Interior">
            <button class="play-button"></button>
        </div>
        <div class="form-container">
            <h1>Reservation</h1>
            <h2>Book A Table Online</h2>
            <form action="process_booking.php" method="post" onsubmit="return validateBooking()">
                <!-- Hiển thị tên người dùng (readonly) -->
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userName); ?>" readonly>

                <!-- Thay trường chọn email thành chọn bàn -->
                <label for="table">Choose a Table</label>
                <select id="table" name="table" required>
                    <?php while ($row = $result_tables->fetch_assoc()): ?>
                        <option value="<?php echo $row['table_id']; ?>" data-table-number="<?php echo $row['table_number']; ?>">
                            Table <?php echo $row['table_number']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <!-- Các trường còn lại -->
                <label for="date">Date & Time</label>
                <input type="datetime-local" id="date" name="date" required>
                <label for="request">Special Request</label>
                <textarea id="request" name="request" rows="3"></textarea>

                <!-- Nút BOOK NOW -->
                <button type="submit" class="btn">BOOK NOW</button>
            </form>
        </div>
    </div>
    <script>
        document.querySelector('form').addEventListener('submit', function() {
            const tableSelect = document.getElementById('table');
            const selectedOption = tableSelect.options[tableSelect.selectedIndex];
            const tableNumber = selectedOption.getAttribute('data-table-number');

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'table_number'; // Tên của trường
            hiddenInput.value = tableNumber; // Giá trị của table_number

            this.appendChild(hiddenInput); // Thêm vào form
        });
    </script>

</body>
</html>
