<?php
session_start();
include 'config/config.php';

if (isset($_POST['dish_id']) && isset($_POST['quantity'])) {
    $dishId = $_POST['dish_id'];
    $quantity = (int)$_POST['quantity'];

    // Retrieve the dish details from the database
    $sql = "SELECT dish_name, price FROM menu WHERE dish_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $dishId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Add dish to the cart
        $item = [
            'dish_name' => $row['dish_name'],
            'price' => $row['price'],
            'quantity' => $quantity,
        ];

        // Check if the dish is already in the cart
        $found = false;
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['dish_name'] === $item['dish_name']) {
                $cartItem['quantity'] += $quantity; // Increase quantity
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = $item; // Add new item
        }

        // Return dish name and price as JSON for the response
        echo json_encode([
            'dish_name' => $item['dish_name'],
            'price' => $item['price'],
        ]);
    } else {
        echo json_encode(['error' => 'Dish not found.']);
    }
} else {
    echo json_encode(['error' => 'Invalid data.']);
}
