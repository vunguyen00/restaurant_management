<?php
session_start(); // Bắt đầu session
include 'config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn dữ liệu người dùng từ cơ sở dữ liệu
    $sql = "SELECT * FROM user WHERE user_name = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Kiểm tra mật khẩu với hàm password_verify
        if (password_verify($password, $row['password'])) {
            // Đăng nhập thành công, lưu tên người dùng và vai trò vào session
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['user_id'] = $row['user_id']; // Nếu bạn muốn lưu user_id

            // Chuyển hướng dựa trên vai trò
            if ($row['role'] == 0) {
                header("Location: user_interface/HomePage.php");
            } else {
                header("Location: admin_interface/admin.php");
            }
            exit();
        } else {
            echo "Sai mật khẩu!";
        }
    } else {
        echo "Tên người dùng không tồn tại!";
    }
}
?>

<!-- Form đăng nhập -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Đăng nhập Huyền Ảo</title>
    <link rel="stylesheet" href="loginstyle.css">
</head>
<body>
    <form method="POST" action="login.php">
        <label for="username">Your Name</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required><br>

        <label for="password">Your Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required><br>

        <button type="submit">Log In</button>

        <p class="register-link">Don't have an account? <a href="register.php">Sign up now</a></p>
    </form>
</body>
</html>

