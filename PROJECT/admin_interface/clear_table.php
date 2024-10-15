<?php
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['table_id'])) {
    $tableId = $_POST['table_id'];

    // Xóa các món ăn trong bảng table_orders cho bàn hiện tại
    $deleteQuery = "DELETE FROM table_orders WHERE table_id = ?";
    if ($stmt = $mysqli->prepare($deleteQuery)) {
        $stmt->bind_param("i", $tableId);
        $stmt->execute();
        $stmt->close();
        echo "Table cleared successfully";
    } else {
        echo "Error clearing table: " . $mysqli->error;
    }
    
    // Đặt lại trạng thái bàn là trống (empty)
    $updateStatusQuery = "UPDATE restaurant_table SET status = 'empty' WHERE table_id = ?";
    if ($stmt = $mysqli->prepare($updateStatusQuery)) {
        $stmt->bind_param("i", $tableId);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error updating table status: " . $mysqli->error;
    }
} else {
    echo "Invalid request or missing table ID";
}

$mysqli->close();
?>
