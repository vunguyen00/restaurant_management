<?php
include("config/config.php");

// Kiểm tra xem yêu cầu có phải là POST và có ID đơn hàng không
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $orderId = $_POST['id']; // Giả sử id ở đây là order_id

    // Truy vấn danh sách món ăn và số lượng từ bảng orders_items
    $query = "
        SELECT m.dish_name, oi.quantity, m.price
        FROM order_items oi
        JOIN menu m ON oi.dish_name = m.dish_name 
        JOIN orders o ON oi.order_id = o.order_id
        WHERE o.order_id = ?
    ";

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();

        $dishesList = array();
        while ($row = $result->fetch_assoc()) {
            $dishesList[] = array(
                'dish_name' => $row['dish_name'],
                'quantity' => $row['quantity'], // Thêm trường số lượng
                'price' => $row['price']
            );
        }

        // Tạo phản hồi JSON thành công
        $response = array(
            'success' => true,
            'dishes' => $dishesList
        );
    } else {
        // Tạo phản hồi lỗi nếu không thể chuẩn bị câu truy vấn
        $response = array(
            'success' => false,
            'error' => 'Error preparing statement: ' . $mysqli->error
        );
    }
} else {
    // Tạo phản hồi lỗi nếu yêu cầu không hợp lệ
    $response = array(
        'success' => false,
        'error' => 'Invalid request or missing order ID'
    );
}

// Thiết lập tiêu đề nội dung là JSON
header('Content-Type: application/json');
echo json_encode($response);

// Đóng kết nối
$mysqli->close();
?>
