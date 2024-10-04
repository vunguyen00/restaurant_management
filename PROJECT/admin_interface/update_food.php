<?php
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients']; // Mảng nguyên liệu

    // Cập nhật thông tin món ăn
    $query = "UPDATE menu SET dish_name = ?, price = ?, dish_describe = ? WHERE dish_id = ?";
    
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("sdsi", $name, $price, $description, $id);
        if ($stmt->execute()) {
            // Xóa nguyên liệu cũ
            $mysqli->query("DELETE FROM dish_ingredients WHERE dish_id = $id");

            // Thêm nguyên liệu mới
            if (!empty($ingredients)) {
                foreach ($ingredients as $ingredient_id) {
                    $query_ingredient = "INSERT INTO dish_ingredients (dish_id, ingredient_id) VALUES (?, ?)";
                    if ($stmt_ingredient = $mysqli->prepare($query_ingredient)) {
                        $stmt_ingredient->bind_param("ii", $id, $ingredient_id);
                        $stmt_ingredient->execute();
                        $stmt_ingredient->close();
                    }
                }
            }
            echo "Food item updated successfully!";
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
