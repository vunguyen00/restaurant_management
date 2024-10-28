<?php
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableId = $_POST['table_id'];
    $dishes = $_POST['dishes'];
    $quantities = $_POST['quantities'];
    $customerName = $_POST['customer_name'] ?? 'Khách ngồi ghép';

    if (empty($dishes)) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng chọn ít nhất một món.']);
        exit;
    }

    // Tạo đơn hàng mới cho khách ngồi ghép
    $orderQuery = "INSERT INTO orders (table_id, customer_name, status) VALUES ('$tableId', '$customerName', 'pending')";
    if ($mysqli->query($orderQuery)) {
        $orderId = $mysqli->insert_id;

        // Lưu các món đã chọn vào chi tiết đơn hàng
        foreach ($dishes as $dishId) {
            $quantity = $quantities[$dishId];
            $mysqli->query("INSERT INTO order_details (order_id, dish_id, quantity) VALUES ('$orderId', '$dishId', '$quantity')");
        }
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không thể thêm đơn hàng.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ.']);
}
?>
