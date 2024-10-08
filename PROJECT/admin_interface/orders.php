<?php
session_start();
include 'config/config.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$searchResult = []; // Biến lưu trữ kết quả tìm kiếm
$orderId = ''; // Biến để lưu orderId tìm kiếm

// Truy vấn để lấy tất cả đơn hàng đã thanh toán
$sql = "SELECT o.order_id, o.total_price, o.order_date, u.user_name AS customer_name, 
               u.email AS customer_email, u.phone_number AS customer_phone
        FROM orders o
        LEFT JOIN user u ON o.user_id = u.user_id
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
        'customer_name' => $row['customer_name'],
        'customer_email' => $row['customer_email'],
        'customer_phone' => $row['customer_phone'],
    ];
}

// Kiểm tra nếu có yêu cầu tìm kiếm
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    // Truy vấn để lấy thông tin đơn hàng đã thanh toán dựa trên orderId
    $sql = "SELECT o.order_id, o.total_price, o.order_date, u.user_name AS customer_name, 
                   u.email AS customer_email, u.phone_number AS customer_phone,
                   oi.dish_name, oi.quantity, oi.price 
            FROM orders o
            LEFT JOIN user u ON o.user_id = u.user_id
            LEFT JOIN order_items oi ON o.order_id = oi.order_id
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
            $searchResult['order_id'] = $row['order_id'];
            $searchResult['total_price'] = $row['total_price'];
            $searchResult['order_date'] = $row['order_date'];
            $searchResult['customer_name'] = $row['customer_name'];
            $searchResult['customer_email'] = $row['customer_email'];
            $searchResult['customer_phone'] = $row['customer_phone'];
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
        </ul>
    </div>

    <div class="main-content">
        <div class="navbar">
            <a href="#">Home</a>
            <span>admin</span>
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
                <p>Email: <?php echo htmlspecialchars($searchResult['customer_email']); ?></p>
                <p>Phone: <?php echo htmlspecialchars($searchResult['customer_phone']); ?></p>
                <p>Order Date: <?php echo htmlspecialchars($searchResult['order_date']); ?></p>
                <p>Total Price: $<?php echo number_format($searchResult['total_price'], 2); ?></p>

                <table>
                    <thead>
                        <tr>
                            <th>Dish Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($searchResult['items'] as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['dish_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
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
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Order Date</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($paidOrders as $id => $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($id); ?></td>
                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
                                <td><?php echo htmlspecialchars($order['customer_phone']); ?></td>
                                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No paid orders found.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
