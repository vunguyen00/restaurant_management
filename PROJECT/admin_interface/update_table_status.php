<?php
include("config/config.php");

$tableId = $_POST['id']; // ID của bàn
$status = $_POST['status']; // Trạng thái mới (ví dụ: 'occupied')

// Cập nhật trạng thái bàn trong cơ sở dữ liệu
$query = "UPDATE restaurant_table SET status = ? WHERE table_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('si', $status, $tableId);

if ($stmt->execute()) {
    echo "Table status updated successfully.";
} else {
    echo "Error updating table status: " . $mysqli->error;
}

$stmt->close();
?>
