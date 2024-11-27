<?php
session_start();

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Đảm bảo đường dẫn chính xác đến thư viện PHPMailer

// Kiểm tra nếu người dùng đã gửi form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $username = $_POST['username'];
    $phone_number = $_POST['phone_number'];

    // Kết nối đến cơ sở dữ liệu (Giả sử bạn đã kết nối thành công với MySQL)
    $mysqli = new mysqli("localhost", "root", "", "restaurantdb"); // Cập nhật thông tin kết nối của bạn

    // Kiểm tra kết nối
    if ($mysqli->connect_error) {
        die("Kết nối thất bại: " . $mysqli->connect_error);
    }

    // Kiểm tra người dùng trong cơ sở dữ liệu
    $query = "SELECT user_id, email FROM user WHERE user_name = ? AND phone_number = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("si", $username, $phone_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userId = $user['user_id'];
        $userEmail = $user['email'];

        // Tạo mã xác thực ngẫu nhiên
        $verificationCode = rand(100000, 999999);

        // Lưu mã vào session để kiểm tra sau này
        $_SESSION['verification_code'] = $verificationCode;
        $_SESSION['user_id'] = $userId;

        // Gửi email với mã xác thực
        $mail = new PHPMailer(true);
        try {
            // Cấu hình PHPMailer
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Địa chỉ SMTP của Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'nguyenvu00304@gmail.com';  // Địa chỉ email của bạn
            $mail->Password = 'yuem yevq yjqe yhez';  // Mật khẩu email (hoặc App password nếu dùng Gmail)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Người gửi và người nhận
            $mail->setFrom('nguyenvu00304@gmail.com', 'Restaurant');
            $mail->addAddress($userEmail); // Người nhận là email của người dùng

            // Nội dung email
            $mail->isHTML(true);
            $mail->Subject = 'Mã xác thực quên mật khẩu';
            $mail->Body    = 'Mã xác thực của bạn là: ' . $verificationCode;

            // Gửi email
            $mail->send();
            echo 'Mã xác thực đã được gửi đến email của bạn.';
        } catch (Exception $e) {
            echo "Không thể gửi email. Lỗi: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Không tìm thấy người dùng với thông tin này.';
    }
}

// Kiểm tra nếu người dùng nhập mã xác thực đúng
$form_display = false;  // Biến để điều khiển hiển thị form đổi mật khẩu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify'])) {
    $enteredCode = $_POST['verification_code'];

    if ($enteredCode == $_SESSION['verification_code']) {
        // Mã xác thực đúng, hiển thị form thay đổi mật khẩu
        $form_display = true;
    } else {
        echo 'Mã xác thực không đúng. Vui lòng thử lại.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #4CAF50;
        }

        .form-container {
            width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-size: 14px;
            margin: 10px 0 5px;
            display: block;
        }

        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 98%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .password-form {
            display: none;
            text-align: center;
        }

        .password-form form {
            width: 300px;
            margin: 0 auto;
        }

        /* Hiển thị form thay đổi mật khẩu nếu mã xác thực đúng */
        .password-form.show {
            display: block;
        }
    </style>
</head>
<body>
    <h2>Quên Mật Khẩu</h2>
    
    <div class="form-container">
        <!-- Form nhập thông tin người dùng -->
        <form action="" method="POST">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" name="username" required>
            
            <label for="phone_number">Số điện thoại:</label>
            <input type="text" name="phone_number" required>
            
            <button type="submit" name="submit">Gửi Mã Xác Thực</button>
        </form>

        <h2>Nhập Mã Xác Thực</h2>
        <!-- Form nhập mã xác thực -->
        <form action="" method="POST">
            <label for="verification_code">Mã xác thực:</label>
            <input type="text" name="verification_code" required>
            <button type="submit" name="verify">Xác thực</button>
        </form>

        <!-- Form thay đổi mật khẩu sẽ hiển thị nếu mã xác thực đúng -->
        <div class="password-form <?php echo $form_display ? 'show' : ''; ?>">
            <form action="change_password.php" method="POST">
                <label for="new_password">Mật khẩu mới:</label>
                <input type="password" name="new_password" required>
                <button type="submit">Đổi mật khẩu</button>
            </form>
        </div>
        <br>
        <button class="show-btn" id="back-btn" onclick="history.back()">Back</button>
    </div>
</body>
</html>
