<?php
session_start();
include 'config/config.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

// Lấy user_id từ session
$user_id = $_SESSION['user_id'];

// Kiểm tra xem giỏ hàng có rỗng không
if (empty($_SESSION['cart'])) {
    die("Your cart is empty!");
}

// Tính tổng giá tiền
$total_price = array_sum(array_map(function($item) {
    return $item['price'] * $item['quantity'];
}, $_SESSION['cart']));

// Xác nhận đặt hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tạo đơn hàng mới
    $sql = "INSERT INTO orders (user_id, total_price, order_date) VALUES (?, ?, NOW())";
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        die("Preparation failed: " . $mysqli->error);
    }

    $stmt->bind_param('id', $user_id, $total_price);

    if (!$stmt->execute()) {
        die("Order creation failed: " . $stmt->error);
    }

    $order_id = $stmt->insert_id;  // Lấy ID của đơn hàng mới tạo

    // Lưu từng món ăn trong giỏ vào order_items
    foreach ($_SESSION['cart'] as $item) {
        $sql = "INSERT INTO order_items (order_id, dish_name, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        
        if (!$stmt) {
            die("Preparation failed: " . $mysqli->error);
        }

        $stmt->bind_param('isid', $order_id, $item['dish_name'], $item['quantity'], $item['price']);
        
        if (!$stmt->execute()) {
            die("Failed to insert order item: " . $stmt->error);
        }
    }

    // Xóa giỏ hàng sau khi thanh toán
    unset($_SESSION['cart']);

    echo "Order placed successfully!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="checkout.css">
    <script>
    function confirmCheckout() {
        return confirm("Are you sure you want to place this order?");
    }
    </script>
</head>
<body>

<div class="container">
    <h1>Checkout</h1>
    <p>Total Price: $<?php echo number_format($total_price, 2); ?></p>

    <form method="POST" onsubmit="return confirmCheckout();">
        <button type="submit" style="background-color: #ff9900; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">Confirm Order</button>
    </form>
</div>

</body>
</html>
