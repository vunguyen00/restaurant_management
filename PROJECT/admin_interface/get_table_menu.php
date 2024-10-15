<?php
include 'config/config.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set the content type to JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table_id'])) {
    $tableId = $_POST['table_id'];

    // Query to get the list of dishes and quantities from `table_orders`
    $query = "
        SELECT m.dish_name, t.quantity, m.price
        FROM table_orders t
        JOIN menu m ON t.dish_id = m.dish_id
        WHERE t.table_id = ?
    ";

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $tableId);
        $stmt->execute();
        $result = $stmt->get_result();

        $dishesList = array();
        while ($row = $result->fetch_assoc()) {
            $dishesList[] = array(
                'dish_name' => $row['dish_name'],
                'quantity' => $row['quantity'],
                'price' => $row['price']
            );
        }

        // Successful JSON response
        echo json_encode(['success' => true, 'dishes' => $dishesList]);
    } else {
        // Error response if query preparation fails
        echo json_encode(['success' => false, 'error' => 'Error preparing statement: ' . $mysqli->error]);
    }
} else {
    // Error response for invalid requests
    echo json_encode(['success' => false, 'error' => 'Invalid request or missing table ID']);
}

// Close the connection
$mysqli->close();
?>