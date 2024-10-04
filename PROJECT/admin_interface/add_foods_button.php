<?php
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients']; // Mảng nguyên liệu

    // Thêm món ăn vào bảng menu
    $query = "INSERT INTO menu (dish_name, price, dish_describe) VALUES (?, ?, ?)";
    
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("sds", $name, $price, $description);
        if ($stmt->execute()) {
            $dish_id = $stmt->insert_id; // Lấy ID món ăn vừa thêm

            // Thêm nguyên liệu vào bảng dish_ingredients
            if (!empty($ingredients)) {
                foreach ($ingredients as $ingredient_id) {
                    $query_ingredient = "INSERT INTO dish_ingredients (dish_id, ingredient_id) VALUES (?, ?)";
                    if ($stmt_ingredient = $mysqli->prepare($query_ingredient)) {
                        $stmt_ingredient->bind_param("ii", $dish_id, $ingredient_id);
                        $stmt_ingredient->execute();
                        $stmt_ingredient->close();
                    }
                }
            }
            echo "Food item added successfully!";
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
