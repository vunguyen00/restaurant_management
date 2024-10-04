<?php
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ingredient_id = $_POST['id'];

    $query = "DELETE FROM ingredients WHERE ingredient_id = $ingredient_id";
    
    if ($mysqli->query($query)) {
        echo "Ingredient deleted successfully.";
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>
