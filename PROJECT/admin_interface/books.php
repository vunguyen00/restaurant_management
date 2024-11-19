<?php 
include("config/config.php");
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_SESSION['user_name'])) {
    $userName = $_SESSION['user_name'];  // Get user name from session
    $userRoleQuery = "SELECT role FROM user WHERE user_name = '$userName'";
    $roleResult = $mysqli->query($userRoleQuery);
    $userRole = $roleResult->fetch_assoc()['role'];
} else {
    $userName = "USER"; 
}
// Khởi tạo biến để lưu kết quả tìm kiếm
$search_query = "";

// Kiểm tra xem có giá trị tìm kiếm không
if (isset($_POST['search'])) {
    $search_query = $mysqli->real_escape_string($_POST['search']);
}

// Truy vấn thông tin đặt bàn cùng với số điện thoại của người dùng
$sql = "SELECT b.booking_id, u.user_name, u.phone_number, t.table_number, b.booking_time, special_request
        FROM booking_history b 
        JOIN user u ON b.user_id = u.user_id 
        JOIN restaurant_table t ON b.table_id = t.table_id";

// Nếu có giá trị tìm kiếm, thêm điều kiện WHERE
if (!empty($search_query)) {
    $sql .= " WHERE u.user_name LIKE '%$search_query%' OR u.phone_number LIKE '%$search_query%'";
}

$result = $mysqli->query($sql);

// Kiểm tra kết quả truy vấn
if (!$result) {
    die("Query failed: " . $mysqli->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="books.css">
</head>
<body>
    <div class="sidebar">
        <h2>LOGO</h2>
        <ul>
            <li><a href="admin.php">Home</a></li>
            <li><a href="admins.php">Admins</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="foods.php">Foods</a></li>
            <li><a href="books.php">Bookings</a></li>
            <li><a href="statistics.php" class="button">Revenue & Dish Statistics</a></li>
            <li><a href="statistical.php">Revenue Statistics</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="navbar">
            <a href="#">Home</a>
            <div class="dropdown">
            <a href="#" class="user-btn" id="user-btn"><?php echo htmlspecialchars($userName); ?></a>
                <div class="dropdown-content">
                    <a href="logout.php">Log Out</a>
                    <a href="../information.php">Information</a>
                </div>
            </div>
        </div>

        <div class="bookings-section">
            <h2>Bookings</h2>
            
            <!-- Form tìm kiếm -->
            <form method="post" action="">
                <input type="text" name="search" placeholder="Search by name or phone" value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit">Search</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>User Name</th>
                        <th>Phone Number</th>
                        <th>Table Number</th>
                        <th>Booking Time</th>
                        <th>Special Request</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['booking_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['table_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['booking_time']); ?></td>
                            <td><?php echo htmlspecialchars($row['special_request']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // JavaScript for the dropdown
        var userBtn = document.getElementById('user-btn');
        var dropdownContent = document.querySelector('.dropdown-content');

        userBtn.addEventListener('click', function (e) {
            e.preventDefault();
            dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
        });

        window.addEventListener('click', function (e) {
            if (!userBtn.contains(e.target) && !dropdownContent.contains(e.target)) {
                dropdownContent.style.display = 'none';
            }
        });
    </script>
</body>
</html>