<?php
include("config/config.php");

$tableId = $_POST['id'];

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
