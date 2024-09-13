<?php
include("config/config.php");

$tableId = $_POST['table_id'];
$dishes = $_POST['dishes'] ?? [];

// Xóa tất cả món ăn hiện tại của bàn này
$deleteQuery = "DELETE FROM orders WHERE table_id = ?";
$stmt = $mysqli->prepare($deleteQuery);
$stmt->bind_param("i", $tableId);
$stmt->execute();

// Thêm các món ăn mới
$insertQuery = "INSERT INTO orders (table_id, dish_id) VALUES (?, ?)";
$stmt = $mysqli->prepare($insertQuery);

foreach ($dishes as $dishId) {
    $stmt->bind_param("ii", $tableId, $dishId);
    $stmt->execute();
}

// Truy vấn lại danh sách món ăn của bàn này
$query = "
    SELECT d.dish_name, COUNT(o.dish_id) AS quantity 
    FROM orders o 
    JOIN menu d ON o.dish_id = d.dish_id 
    WHERE o.table_id = ? 
    GROUP BY d.dish_id
";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $tableId);
$stmt->execute();
$result = $stmt->get_result();

$dishesList = array();
while ($row = $result->fetch_assoc()) {
    $dishesList[] = $row;
}

$response = array(
    'success' => true,
    'dishes' => $dishesList
);

header('Content-Type: application/json');
echo json_encode($response);
?>
