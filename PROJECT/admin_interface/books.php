<?php 
include("config/config.php");

// Khởi tạo biến để lưu kết quả tìm kiếm
$search_query = "";

// Kiểm tra xem có giá trị tìm kiếm không
if (isset($_POST['search'])) {
    $search_query = $mysqli->real_escape_string($_POST['search']);
}

// Truy vấn thông tin đặt bàn cùng với số điện thoại của người dùng
$sql = "SELECT b.booking_id, u.user_name, u.phone_number, t.table_number, b.booking_time 
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
        </ul>
    </div>

    <div class="main-content">
        <div class="navbar">
            <a href="#">Home</a>
            <span>admin</span>
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
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
