<?php
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $imagePath = ''; // Đường dẫn ảnh, mặc định là rỗng

    // Kiểm tra và xử lý file ảnh (nếu có)
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../storage/";  // Thư mục lưu ảnh
        $imageName = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . time() . "_" . $imageName; // Tạo tên file duy nhất

        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Di chuyển file ảnh vào thư mục storage
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $imagePath = $targetFilePath; // Đường dẫn ảnh lưu vào CSDL
        } else {
            echo "Error: Unable to upload image.";
            exit();
        }
    }

    // Thêm món ăn vào bảng menu cùng với đường dẫn ảnh
    $query = "INSERT INTO menu (dish_name, price, dish_describe, image_path) VALUES (?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("sdss", $name, $price, $description, $imagePath);
        if ($stmt->execute()) {
            echo "Food item added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
    }

    // Đóng kết nối
    $mysqli->close();
}
?>
