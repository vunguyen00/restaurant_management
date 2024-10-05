<?php
// Bao gồm file config.php để sử dụng biến kết nối $mysqli
include 'config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Kiểm tra độ dài mật khẩu và chứa ký tự đặc biệt
    if (strlen($password) < 8 || strlen($password) > 16 || !preg_match('/[^a-zA-Z\d]/', $password)) {
        echo "Mật khẩu phải từ 8-16 ký tự và chứa ít nhất 1 ký tự đặc biệt.";
    } else {
        // Kiểm tra xem tên đăng nhập đã tồn tại hay chưa
        $check_username = "SELECT * FROM user WHERE user_name = '$username'";
        $result_username = $mysqli->query($check_username);
        
        if ($result_username->num_rows > 0) {
            echo "Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.";
        } else {
            // Kiểm tra xem email đã được đăng ký hay chưa
            $check_email = "SELECT * FROM user WHERE email = '$email'";
            $result_email = $mysqli->query($check_email);
            
            if ($result_email->num_rows > 0) {
                echo "Email này đã được đăng ký. Vui lòng chọn email khác.";
            } else {
                // Kiểm tra xem số điện thoại đã được đăng ký hay chưa
                $check_phone = "SELECT * FROM user WHERE phone_number = '$phone'";
                $result_phone = $mysqli->query($check_phone);

                if ($result_phone->num_rows > 0) {
                    echo "Số điện thoại này đã được đăng ký. Vui lòng chọn số điện thoại khác.";
                } else {
                    // Mã hóa mật khẩu
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Câu lệnh SQL để thêm dữ liệu vào bảng user với cột role mặc định là 0
                    $sql = "INSERT INTO user (user_name, email, phone_number, password, role) VALUES ('$username', '$email', '$phone', '$hashed_password', 0)";

                    // Thực hiện câu lệnh SQL
                    if ($mysqli->query($sql) === TRUE) {                        
                        echo "Đăng ký thành công!";
                        header("Location: login.php");
                        exit(); // Thêm exit để ngăn tiếp tục thực hiện mã sau header
                    } else {
                        echo "Lỗi: " . $sql . "<br>" . $mysqli->error;
                    }
                }
            }
        }
    }
}
?>

<!-- Form đăng ký -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Đăng ký Huyền Ảo</title>
    <link rel="stylesheet" href="registercss.css">
</head>
<body>
    <form method="POST" action="register.php">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" placeholder="Nhập tên đăng nhập" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Nhập email" required><br>

        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại"><br>

        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required><br>

        <button type="submit">Đăng ký</button>
    </form>
</body>
</html>
