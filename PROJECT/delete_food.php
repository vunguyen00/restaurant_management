<?php
include("config/config.php");

// Kiểm tra xem yêu cầu có phải là POST và có ID món ăn không
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    // Lấy ID món ăn từ yêu cầu POST
    $id = $_POST['id'];

    // Chuẩn bị câu lệnh SQL để xóa món ăn
    $query = "DELETE FROM menu WHERE dish_id = ?";
    
    // Kiểm tra và thực hiện câu lệnh SQL
    if ($stmt = $mysqli->prepare($query)) {
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
