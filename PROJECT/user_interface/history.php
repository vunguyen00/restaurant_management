<?php
session_start();
include 'config/config.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id']; // Lấy user_id từ session

// Truy vấn để lấy thông tin lịch sử đơn hàng của người dùng dựa trên user_id
$sql = "SELECT o.order_id, o.total_price, o.order_date, oi.dish_name, oi.quantity, oi.price 
        FROM orders o
        LEFT JOIN order_items oi ON o.order_id = oi.order_id
        WHERE o.user_id = ?  -- Đổi user_name thành user_id
        ORDER BY o.order_date DESC";

$stmt = $mysqli->prepare($sql);

// Kiểm tra nếu chuẩn bị câu lệnh thất bại
if (!$stmt) {
    die("SQL preparation failed: " . $mysqli->error);
}

$stmt->bind_param("i", $userId); // user_id là kiểu số nguyên
$stmt->execute();
$result = $stmt->get_result();

$orderHistory = [];
while ($row = $result->fetch_assoc()) {
    $orderHistory[$row['order_id']]['order_date'] = $row['order_date'];
    $orderHistory[$row['order_id']]['total_price'] = $row['total_price'];
    $orderHistory[$row['order_id']]['items'][] = [
        'dish_name' => $row['dish_name'],
        'quantity' => $row['quantity'],
        'price' => $row['price']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="history.css">
</head>
<body>

<div class="container">
    <h1>Your Order History</h1>

    <?php if (!empty($orderHistory)): ?>
        <?php foreach ($orderHistory as $orderId => $order): ?>
            <div class="order">
                <h3>Order CODE: <?php echo $orderId; ?></h3>
                <p>Order Date: <?php echo $order['order_date']; ?></p>
                <p>Total Price: $<?php echo number_format($order['total_price'], 2); ?></p>

                <table>
                    <thead>
                        <tr>
                            <th>Dish Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order['items'] as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['dish_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p>You have no order history.</p>
    <?php endif; ?>
</div>

</body>
</html>
