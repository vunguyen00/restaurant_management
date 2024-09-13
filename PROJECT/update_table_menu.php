<?php
include("config/config.php");

$tableId = $_POST['table_id'];
$dishes = $_POST['dishes'] ?? [];
$quantities = $_POST['quantities'] ?? []; // Thêm phần nhận số lượng món ăn

// Xóa tất cả món ăn hiện tại của bàn này
$deleteQuery = "DELETE FROM orders WHERE table_id = ?";
$stmt = $mysqli->prepare($deleteQuery);
$stmt->bind_param("i", $tableId);
$stmt->execute();

// Thêm các món ăn mới với số lượng
$insertQuery = "INSERT INTO orders (table_id, dish_id, quantity) VALUES (?, ?, ?)";
$stmt = $mysqli->prepare($insertQuery);

foreach ($dishes as $dishId) {
    // Kiểm tra xem có số lượng của món ăn này không, nếu không thì mặc định là 1
    $quantity = isset($quantities[$dishId]) ? $quantities[$dishId] : 1;
    $stmt->bind_param("iii", $tableId, $dishId, $quantity);
    $stmt->execute();
}

// Truy vấn lại danh sách món ăn của bàn này với số lượng
$query = "
    SELECT d.dish_name, SUM(o.quantity) AS quantity 
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
