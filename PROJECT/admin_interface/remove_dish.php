<?php
header('Content-Type: application/json');
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['table_id']) || !isset($_POST['dish_name'])) {
        echo json_encode(['success' => false, 'error' => 'Thiếu tham số.']);
        exit;
    }

    $table_id = (int)$_POST['table_id'];
    $dish_name = $_POST['dish_name'];

    // Bước 1: Lấy dish_id từ table_menu dựa trên tên món ăn
    $selectQuery = "SELECT dish_id FROM menu WHERE dish_name = ?";
    $stmt = $mysqli->prepare($selectQuery);
    $stmt->bind_param("s", $dish_name);
    $stmt->execute();
    $stmt->bind_result($dish_id);
    $stmt->fetch();
    $stmt->close();

    // Kiểm tra xem dish_id có được tìm thấy không
    if (!$dish_id) {
        echo json_encode(['success' => false, 'error' => 'Món ăn không tồn tại.']);
        exit;
    }

    // Bước 2: Xóa món ăn từ table_orders
    $deleteQuery = "DELETE FROM table_orders WHERE table_id = ? AND dish_id = ?";
    $stmt = $mysqli->prepare($deleteQuery);
    $stmt->bind_param("ii", $table_id, $dish_id);
    $deletion_success = $stmt->execute();
    $stmt->close();

    // Bước 3: Kiểm tra xem bàn có còn món nào không
    $checkQuery = "SELECT COUNT(*) FROM table_orders WHERE table_id = ?";
    $stmt = $mysqli->prepare($checkQuery);
    $stmt->bind_param("i", $table_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // Nếu không còn món nào, cập nhật trạng thái bàn thành 'empty'
    if ($count === 0) {
        $updateStatusQuery = "UPDATE restaurant_table SET status = 'empty' WHERE table_id = ?";
        $stmt = $mysqli->prepare($updateStatusQuery);
        $stmt->bind_param("i", $table_id);
        $stmt->execute();
        $stmt->close();
    }

    // Trả về kết quả
    echo json_encode(['success' => $deletion_success]);
} else {
    echo json_encode(['success' => false, 'error' => 'Yêu cầu không hợp lệ.']);
}
?>
