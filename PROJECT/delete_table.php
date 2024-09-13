<?php
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableId = $_POST['table_id'];

    if ($tableId) {
        // Thực hiện truy vấn để xóa bàn
        $deleteQuery = "DELETE FROM restaurant_table WHERE table_id = ?";
        $stmt = $mysqli->prepare($deleteQuery);
        $stmt->bind_param("i", $tableId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error executing delete query']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'No table ID provided']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
