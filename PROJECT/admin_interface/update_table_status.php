<?php
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['table_id']) && isset($_POST['dishes'])) {
    $tableId = $_POST['table_id']; // ID của bàn
    $dishes = $_POST['dishes']; // Các món ăn được chọn
    $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];

    // Nếu có món ăn thì cập nhật trạng thái bàn thành 'occupied'
    if (!empty($dishes)) {
        // Cập nhật trạng thái của bàn thành 'occupied'
        $status = 'occupied'; 
        $query = "UPDATE restaurant_table SET status = ? WHERE table_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('si', $status, $tableId);

        if ($stmt->execute()) {
            // Nếu cập nhật trạng thái thành công, thêm món ăn vào bảng `table_orders`
            foreach ($dishes as $dish_id) {
                $quantity = isset($quantities[$dish_id]) ? $quantities[$dish_id] : 1;

                // Kiểm tra xem món ăn đã tồn tại trong đơn hàng chưa
                $checkQuery = "SELECT * FROM table_orders WHERE table_id = ? AND dish_id = ?";
                $checkStmt = $mysqli->prepare($checkQuery);
                $checkStmt->bind_param("ii", $tableId, $dish_id);
                $checkStmt->execute();
                $checkResult = $checkStmt->get_result();

                if ($checkResult->num_rows > 0) {
                    // Nếu món ăn đã có, cập nhật số lượng
                    $updateQuery = "UPDATE table_orders SET quantity = quantity + ? WHERE table_id = ? AND dish_id = ?";
                    $updateStmt = $mysqli->prepare($updateQuery);
                    $updateStmt->bind_param("iii", $quantity, $tableId, $dish_id);
                    $updateStmt->execute();
                    $updateStmt->close();
                } else {
                    // Nếu món ăn chưa có, thêm mới vào bảng `table_orders`
                    $insertQuery = "INSERT INTO table_orders (table_id, dish_id, quantity) VALUES (?, ?, ?)";
                    $insertStmt = $mysqli->prepare($insertQuery);
                    $insertStmt->bind_param("iii", $tableId, $dish_id, $quantity);
                    $insertStmt->execute();
                    $insertStmt->close();
                }

                $checkStmt->close();
            }

            echo "Table status updated and dishes added successfully.";
        } else {
            echo "Error updating table status: " . $mysqli->error;
        }

        $stmt->close();
    } else {
        // Nếu không có món ăn nào được chọn, trả về thông báo lỗi
        echo "No dishes selected.";
    }
} else {
    // Trả về lỗi nếu yêu cầu không hợp lệ
    echo "Invalid request.";
}

$mysqli->close();
?>
