<?php
header('Content-Type: application/json');
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['table_id']) || !isset($_POST['dish_id']) || !isset($_POST['quantity'])) {
        echo json_encode(['success' => false, 'error' => 'Missing parameters.']);
        exit;
    }

    $table_id = $_POST['table_id'];
    $dish_id = $_POST['dish_id'];
    $quantity = $_POST['quantity'];

    // Truy vấn xóa món ăn theo table_id, dish_id và quantity
    $deleteQuery = "DELETE FROM table_orders WHERE table_id = ? AND dish_id = ? AND quantity = ?";
    $stmt = $mysqli->prepare($deleteQuery);
    $stmt->bind_param("iii", $table_id, $dish_id, $quantity);
    $deletion_success = $stmt->execute();
    $stmt->close();

    if ($deletion_success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to remove the dish.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}
?>
