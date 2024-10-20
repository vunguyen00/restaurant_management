<?php
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['table_id']) && isset($_POST['dishes'])) {
    $table_id = $_POST['table_id'];
    $dishes = $_POST['dishes']; 
    $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];

    // Thêm món ăn mới cùng số lượng vào bảng table_orders
    foreach ($dishes as $dish_id) {
        $quantity = isset($quantities[$dish_id]) ? $quantities[$dish_id] : 1;

        // Kiểm tra xem món ăn đã có trong bảng orders chưa
        $checkQuery = "SELECT * FROM table_orders WHERE table_id = ? AND dish_id = ?";
        if ($checkStmt = $mysqli->prepare($checkQuery)) {
            $checkStmt->bind_param("ii", $table_id, $dish_id);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                // Nếu món ăn đã tồn tại, cập nhật số lượng
                $updateQuery = "UPDATE table_orders SET quantity = quantity + ? WHERE table_id = ? AND dish_id = ?";
                if ($updateStmt = $mysqli->prepare($updateQuery)) {
                    $updateStmt->bind_param("iii", $quantity, $table_id, $dish_id);
                    $updateStmt->execute();
                    $updateStmt->close();
                }
            } else {
                // Nếu món ăn chưa tồn tại, thêm mới
                $insertQuery = "INSERT INTO table_orders (table_id, dish_id, quantity) VALUES (?, ?, ?)";
                if ($insertStmt = $mysqli->prepare($insertQuery)) {
                    $insertStmt->bind_param("iii", $table_id, $dish_id, $quantity);
                    $insertStmt->execute();
                    $insertStmt->close();
                }
            }

            $checkStmt->close();
        }
    }

    // Cập nhật trạng thái bàn là 'occupied'
    $updateTableStatusQuery = "UPDATE restaurant_table SET status = 'occupied' WHERE table_id = ?";
    if ($statusStmt = $mysqli->prepare($updateTableStatusQuery)) {
        $statusStmt->bind_param("i", $table_id);
        $statusStmt->execute();
        $statusStmt->close();
    }

    // Trả về phản hồi JSON thành công
    echo json_encode(['success' => true]);
} else {
    // Trả về phản hồi lỗi
    echo json_encode(['success' => false, 'error' => 'Invalid request or missing data']);
}

$mysqli->close();
?>
