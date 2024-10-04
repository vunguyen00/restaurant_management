<?php
include("config/config.php");

$tableId = $_POST['id'];

// Truy vấn danh sách món ăn cùng số lượng và giá
$query = "
<<<<<<< HEAD:PROJECT/admin_interface/get_table_menu.php
    SELECT m.dish_name, o.quantity ,m.price
=======
    SELECT m.dish_name, o.quantity, m.price 
>>>>>>> 680ee18670dfceab7f0b659d8f149eee34a7d582:PROJECT/get_table_menu.php
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
<<<<<<< HEAD:PROJECT/admin_interface/get_table_menu.php
        'price' => $row['price']
=======
        'price' => $row['price']  // Thêm trường giá
>>>>>>> 680ee18670dfceab7f0b659d8f149eee34a7d582:PROJECT/get_table_menu.php
    );
}

$response = array(
    'success' => true,
    'dishes' => $dishesList
);

header('Content-Type: application/json');
echo json_encode($response);
?>
