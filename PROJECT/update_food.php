<?php
include("config/config.php");

// Kiểm tra xem yêu cầu có phải là POST và có ID món ăn không
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    // Lấy dữ liệu từ yêu cầu POST
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Chuẩn bị câu lệnh SQL để cập nhật món ăn
    $query = "UPDATE menu SET dish_name = ?, price = ?, dish_describe = ? WHERE dish_id = ?";
    
    // Kiểm tra và thực hiện câu lệnh SQL
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("sdsi", $name, $price, $description, $id);

        if ($stmt->execute()) {
            echo "Food item updated successfully!";
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
