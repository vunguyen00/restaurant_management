<?php
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Kiểm tra dữ liệu và chuẩn bị câu lệnh SQL để thêm món ăn vào cơ sở dữ liệu
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
