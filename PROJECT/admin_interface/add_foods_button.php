<?php
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Thêm món ăn vào bảng menu
    $query = "INSERT INTO menu (dish_name, price, dish_describe) VALUES (?, ?, ?)";
    
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("sds", $name, $price, $description);
        if ($stmt->execute()) {
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
