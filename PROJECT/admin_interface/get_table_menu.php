<?php
include("config/config.php");

$tableId = $_POST['id'];

// Truy vấn danh sách món ăn cùng số lượng
$query = "
    SELECT m.dish_name, o.quantity ,m.price
    FROM orders o 
    JOIN menu m ON o.dish_id = m.dish_id 
    WHERE o.table_id = ?
";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $tableId);
$stmt->execute();
$result = $stmt->get_result();

$dishesList = array();
while ($row = $result->fetch_assoc()) {
    $dishesList[] = array(
        'dish_name' => $row['dish_name'],
        'quantity' => $row['quantity'],  // Thêm trường số lượng
        'price' => $row['price']
    );
}

$response = array(
    'success' => true,
    'dishes' => $dishesList
);

header('Content-Type: application/json');
echo json_encode($response);
?>
