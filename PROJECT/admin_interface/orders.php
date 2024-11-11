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

$searchResult = []; // Biến lưu trữ kết quả tìm kiếm
$orderId = ''; // Biến để lưu orderId tìm kiếm

// Truy vấn để lấy tất cả đơn hàng đã thanh toán, bao gồm số bàn từ restaurant_table
$sql = "SELECT o.order_id, o.total_price, o.order_date, o.payment_time, 
               o.customer_name, u.user_name AS admin_user_name, 
               o.customer_phone, 
               rt.table_number
        FROM orders o
        LEFT JOIN user u ON o.user_id = u.user_id
        LEFT JOIN restaurant_table rt ON o.table_id = rt.table_id
        ORDER BY o.order_date DESC";

$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    die("SQL preparation failed: " . $mysqli->error);
}
$stmt->execute();
$result = $stmt->get_result();

$paidOrders = [];
while ($row = $result->fetch_assoc()) {
    $paidOrders[$row['order_id']] = [
        'total_price' => $row['total_price'],
        'order_date' => $row['order_date'],
        'payment_time' => $row['payment_time'], // Thêm thời gian thanh toán
        'customer_name' => $row['customer_name'], // Tên khách hàng từ bảng orders
        'customer_phone' => $row['customer_phone'], // Số điện thoại
        'admin_user_name' => $row['admin_user_name'], // Tên admin (người xử lý ca làm)
        'table_number' => $row['table_number'] // Thêm số bàn
    ];
}

// Kiểm tra nếu có yêu cầu tìm kiếm
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    // Truy vấn để lấy thông tin đơn hàng đã thanh toán dựa trên orderId, bao gồm số bàn
    $sql = "SELECT o.order_id, o.total_price, o.order_date, o.payment_time, 
                   o.customer_name, u.user_name AS admin_user_name, 
                   o.customer_phone, 
                   oi.dish_name, oi.quantity, oi.price,
                   rt.table_number
            FROM orders o
            LEFT JOIN user u ON o.user_id = u.user_id
            LEFT JOIN order_items oi ON o.order_id = oi.order_id
            LEFT JOIN restaurant_table rt ON o.table_id = rt.table_id
            WHERE o.order_id = ? ";
    $stmt = $mysqli->prepare($sql);
    
    if (!$stmt) {
        die("SQL preparation failed: " . $mysqli->error);
    }

    $stmt->bind_param("i", $orderId); // orderId là kiểu số nguyên
    if (!$stmt->execute()) {
        die("Execution failed: " . $stmt->error); // Handle execution error
    }

    $result = $stmt->get_result();

    // Lưu trữ thông tin đơn hàng vào biến $searchResult
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Lưu thông tin chung
            $searchResult['order_id'] = $row['order_id'];
            $searchResult['total_price'] = $row['total_price'];
            $searchResult['order_date'] = $row['order_date'];
            $searchResult['payment_time'] = $row['payment_time']; // Thêm thời gian thanh toán
            $searchResult['customer_name'] = $row['customer_name']; // Tên khách hàng
            $searchResult['customer_phone'] = $row['customer_phone']; // Số điện thoại
            $searchResult['admin_user_name'] = $row['admin_user_name']; // Tên admin
            $searchResult['table_number'] = $row['table_number']; // Thêm số bàn
            
            // Lưu thông tin món ăn
            $searchResult['items'][] = [
                'dish_name' => $row['dish_name'],
                'quantity' => $row['quantity'],
                'price' => $row['price']
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="orders.css">
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
            <a href="#" class="user-btn"><?php echo htmlspecialchars($userName); ?></a>
                <div class="dropdown-content">
                    <a href="logout.php">Log Out</a>
                </div>
            </div>
        </div>

        <div class="orders-section">
            <h2>Orders</h2>
            <form method="POST" action="">
                <input type="text" name="order_id" placeholder="Enter Order ID" value="<?php echo htmlspecialchars($orderId); ?>" required>
                <button type="submit">Search</button>
            </form>

            <h3>Paid Orders</h3>
            <?php if (!empty($searchResult)): ?>
                <h3>Order ID: <?php echo htmlspecialchars($searchResult['order_id']); ?></h3>
                <p>Customer Name: <?php echo htmlspecialchars($searchResult['customer_name']); ?></p>
                <p>Phone: <?php echo htmlspecialchars($searchResult['customer_phone']); ?></p>
                <p>Ca: <?php echo htmlspecialchars($searchResult['admin_user_name']); ?></p> <!-- Hiển thị tên admin -->
                <p>Table Number: <?php echo htmlspecialchars($searchResult['table_number']); ?></p> <!-- Hiển thị số bàn -->
                <p>Order Date: <?php echo htmlspecialchars($searchResult['order_date']); ?></p>
                <p>Payment Time: <?php echo htmlspecialchars($searchResult['payment_time']); ?></p> <!-- Thêm thời gian thanh toán -->
                <p>Total Price: <?php echo number_format($searchResult['total_price'], 2); ?> VNĐ</p>

                <table>
                    <thead>
                        <tr>
                            <th>Dish Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($searchResult['items'])): ?>
                            <?php foreach ($searchResult['items'] as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['dish_name']); ?></td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td><?php echo number_format($item['price'], 2); ?>VNĐ</td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No items found for this order.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <h3>All Paid Orders</h3>
                <?php if (!empty($paidOrders)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Phone Number</th>
                                <th>Admin User Name</th> <!-- Thêm cột tên admin -->
                                <th>Table Number</th> <!-- Thêm cột số bàn -->
                                <th>Order Date</th>
                                <th>Payment Time</th> <!-- Thêm cột thời gian thanh toán -->
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($paidOrders as $id => $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($id); ?></td>
                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['customer_phone']); ?></td>
                                <td><?php echo htmlspecialchars($order['admin_user_name']); ?></td> <!-- Hiển thị tên admin -->
                                <td><?php echo htmlspecialchars($order['table_number']); ?></td> <!-- Hiển thị số bàn -->
                                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                <td><?php echo htmlspecialchars($order['payment_time']); ?></td> <!-- Hiển thị thời gian thanh toán -->
                                <td><?php echo number_format($order['total_price'], ); ?> VNĐ</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No paid orders found.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <script>
                    // JavaScript for the dropdown
                    var userBtn = document.getElementById('userBtn');
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
    </div>
</body>
</html>