<?php
session_start();

// Kết nối đến cơ sở dữ liệu
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'];

    // Mã hóa mật khẩu mới
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Cập nhật mật khẩu mới vào cơ sở dữ liệu
    $userId = $_SESSION['user_id'];
    $updateQuery = "UPDATE user SET password = ? WHERE user_id = ?";
    $stmt = $mysqli->prepare($updateQuery);
    $stmt->bind_param("si", $hashedPassword, $userId);

    if ($stmt->execute()) {
        echo 'Mật khẩu đã được thay đổi thành công!';
        header('Location: login.php');  // Chuyển hướng về trang đăng nhập
    } else {
        echo 'Đã có lỗi xảy ra, vui lòng thử lại.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi Mật Khẩu</title>
</head>
<body>
    <!-- <h2>Đổi Mật Khẩu</h2>
    <form action="" method="POST">
        <label for="new_password">Mật khẩu mới:</label>
        <input type="password" name="new_password" required>
        <button type="submit">Đổi mật khẩu</button>
    </form> -->
</body>
</html>
