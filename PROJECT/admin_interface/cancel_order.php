<?php
include("config/config.php");

// Lấy dữ liệu từ yêu cầu POST
$data = json_decode(file_get_contents("php://input"), true);
$tableId = $data['table_id'] ?? null;

if ($tableId) {
    // Bắt đầu giao dịch
    $mysqli->begin_transaction();

    try {
        // Cập nhật trạng thái bàn về trống
        $updateTableQuery = "UPDATE restaurant_table SET status = 'empty' WHERE table_id = ?";
        $stmt = $mysqli->prepare($updateTableQuery);
        $stmt->bind_param("i", $tableId);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update table status: " . $stmt->error);
        }

        // Xóa tất cả các món ăn trong bảng table_orders cho bàn này
        $deleteOrderQuery = "DELETE FROM table_orders WHERE table_id = ?";
        $stmt = $mysqli->prepare($deleteOrderQuery);
        $stmt->bind_param("i", $tableId);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete orders: " . $stmt->error);
        }

        // Cam kết giao dịch
        $mysqli->commit();
        
        echo json_encode(['success' => true, 'message' => 'Order cancelled and table status updated.']);
    } catch (Exception $e) {
        // Rollback giao dịch trong trường hợp lỗi
        $mysqli->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid table ID.']);
}
?>
