<?php
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $newImagePath = ''; // Đường dẫn ảnh mới

    // Kiểm tra nếu có ảnh mới được tải lên
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../storage/";  // Thư mục lưu ảnh
        $imageName = basename($_FILES['image']['name']);
        $newImagePath = $targetDir . time() . "_" . $imageName; // Tạo tên file duy nhất

        // Tạo thư mục nếu chưa tồn tại
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Lấy đường dẫn ảnh hiện tại từ cơ sở dữ liệu
        $getImageQuery = "SELECT image_path FROM menu WHERE dish_id = ?";
        if ($getImageStmt = $mysqli->prepare($getImageQuery)) {
            $getImageStmt->bind_param("i", $id);
            $getImageStmt->execute();
            $getImageStmt->bind_result($currentImagePath);
            $getImageStmt->fetch();
            $getImageStmt->close();
        }

        // Xóa ảnh cũ nếu có ảnh mới và ảnh cũ tồn tại
        if (!empty($currentImagePath) && file_exists($currentImagePath)) {
            unlink($currentImagePath);
        }

        // Di chuyển file ảnh mới vào thư mục storage
        if (move_uploaded_file($_FILES['image']['tmp_name'], $newImagePath)) {
            // Thành công, lưu đường dẫn ảnh mới vào cơ sở dữ liệu
        } else {
            echo "Error: Unable to upload new image.";
            exit();
        }
    } else {
        // Nếu không có ảnh mới, giữ nguyên đường dẫn ảnh cũ
        $newImagePath = $currentImagePath;
    }

    // Cập nhật thông tin món ăn, bao gồm cả đường dẫn ảnh nếu có
    $query = "UPDATE menu SET dish_name = ?, price = ?, dish_describe = ?, image_path = ? WHERE dish_id = ?";
    
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("sdssi", $name, $price, $description, $newImagePath, $id);
        if ($stmt->execute()) {
            echo "Food item updated successfully!";
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