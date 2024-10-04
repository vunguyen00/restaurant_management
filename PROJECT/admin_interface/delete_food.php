<?php
include("config/config.php");

// Kiểm tra xem yêu cầu có phải là POST và có ID món ăn không
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    // Lấy ID món ăn từ yêu cầu POST
    $id = $_POST['id'];

    // Chuẩn bị câu lệnh SQL để xóa nguyên liệu liên quan
    $queryDeleteIngredients = "DELETE FROM dish_ingredients WHERE dish_id = ?";
    
    // Chuẩn bị câu lệnh SQL để xóa món ăn
    $queryDeleteFood = "DELETE FROM menu WHERE dish_id = ?";
    
    // Thực hiện xóa nguyên liệu liên quan
    if ($stmt = $mysqli->prepare($queryDeleteIngredients)) {
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            echo "Error deleting ingredients: " . $stmt->error;
            $stmt->close();
            $mysqli->close();
            exit;
        }

        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
        $mysqli->close();
        exit;
    }

    // Thực hiện xóa món ăn
    if ($stmt = $mysqli->prepare($queryDeleteFood)) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Food item deleted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
    }

    $mysqli->close();
} else {
    echo "Invalid request.";
}
?>
