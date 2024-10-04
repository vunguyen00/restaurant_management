<?php
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ingredient_name = $_POST['ingredient_name'];
    $quantity = $_POST['quantity'];

    // Thêm nguyên liệu vào bảng ingredients
    $query = "INSERT INTO ingredients (ingredient_name, quantity) VALUES (?, ?)";
    
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("si", $ingredient_name, $quantity);
        if ($stmt->execute()) {
            echo "Ingredient added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
    }
    $mysqli->close();
}
?>
