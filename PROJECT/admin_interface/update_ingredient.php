<?php
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ingredient_id'], $_POST['ingredient_name'], $_POST['quantity'])) {
        $ingredient_id = intval($_POST['ingredient_id']); // Chuyển đổi sang số nguyên
        $ingredient_name = $mysqli->real_escape_string($_POST['ingredient_name']); // Bảo vệ SQL Injection
        $quantity = intval($_POST['quantity']); // Chuyển đổi sang số nguyên

        $query = "UPDATE ingredients SET ingredient_name = '$ingredient_name', quantity = $quantity WHERE ingredient_id = $ingredient_id";
        
        if ($mysqli->query($query)) {
            echo "Ingredient updated successfully.";
        } else {
            echo "Error: " . $mysqli->error;
        }
    } else {
        echo "Missing required fields.";
    }
} else {
    echo "Invalid request method.";
}
?>
