<?php
include("config/config.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    // Nếu người dùng chưa đăng nhập, chuyển hướng về trang đăng nhập
    header("Location: login.php");
    exit();
}

// Lấy thông tin người dùng từ session
$userId = $_SESSION['user_id'];

// Truy vấn cơ sở dữ liệu để lấy thông tin người dùng
$query = "SELECT user_name, phone_number, email, password FROM user WHERE user_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userInfo = $result->fetch_assoc();
} else {
    echo "Không tìm thấy thông tin người dùng.";
    exit();
}

// Xử lý cập nhật thông tin nếu người dùng gửi form cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_info'])) {
    $currentPassword = $_POST['current_password'];
    $newPhoneNumber = $_POST['phone_number'];
    $newEmail = $_POST['email'];

    // Kiểm tra mật khẩu hiện tại
    if (password_verify($currentPassword, $userInfo['password'])) {
        $updateQuery = "UPDATE user SET phone_number = ?, email = ? WHERE user_id = ?";
        $updateStmt = $mysqli->prepare($updateQuery);
        $updateStmt->bind_param("ssi", $newPhoneNumber, $newEmail, $userId);

        if ($updateStmt->execute()) {
        } else {
            echo "<script>alert('Cập nhật thất bại. Vui lòng thử lại.');</script>";
        }
    } else {
        echo "<script>alert('Mật khẩu hiện tại không chính xác. Vui lòng thử lại.');</script>";
    }
}

// Xử lý đổi mật khẩu nếu người dùng gửi form đổi mật khẩu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Kiểm tra mật khẩu hiện tại
    if (password_verify($currentPassword, $userInfo['password'])) {
        if ($newPassword === $confirmPassword) {
            // Mã hóa mật khẩu mới và cập nhật vào cơ sở dữ liệu
            $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $updatePasswordQuery = "UPDATE user SET password = ? WHERE user_id = ?";
            $updatePasswordStmt = $mysqli->prepare($updatePasswordQuery);
            $updatePasswordStmt->bind_param("si", $hashedNewPassword, $userId);

            if ($updatePasswordStmt->execute()) {
            } else {
                echo "<script>alert('Đổi mật khẩu thất bại. Vui lòng thử lại.');</script>";
            }
        } else {
            echo "<script>alert('Mật khẩu mới không khớp. Vui lòng thử lại.');</script>";
        }
    } else {
        echo "<script>alert('Mật khẩu hiện tại không chính xác. Vui lòng thử lại.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1, h2 {
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        form label {
            display: block;
            margin: 10px 0 5px;
            font-size: 16px;
        }
        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        form button {
            background-color: #e68a00;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        form button:hover {
            background-color: #cc7700;
        }
        .form-section {
            margin-bottom: 30px;
            display: none; /* Ẩn form mặc định */
        }
        .show-btn {
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        .show-btn:hover {
            background-color: #007bb5;
        }
    </style>
</head>
<body>
    <div class="container">
        <button class="show-btn" id="back-btn" onclick="history.back()">Back</button>
        <h1>My Information</h1>
        <div>        
            <div class="info-box">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($userInfo['user_name']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($userInfo['phone_number']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($userInfo['email']); ?></p>
        </div></div>
        <!-- Nút để hiển thị form cập nhật thông tin -->
        <button class="show-btn" id="update-info-btn">Update Information</button>
        <button class="show-btn" id="change-password-btn">Change Password</button>

        <!-- Form cập nhật thông tin -->
        <div class="form-section" id="update-info-form">
            <h2>Update Information</h2>
            <form action="" method="POST">
                <input type="hidden" name="update_info" value="1">
                <label for="phone_number">New Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number" value="<?php echo htmlspecialchars($userInfo['phone_number']); ?>" required>
                
                <label for="email">New Email:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($userInfo['email']); ?>" required>
                
                <label for="current_password">Current Password:</label>
                <input type="password" name="current_password" id="current_password" required>

                <button type="submit">Update Information</button>
            </form>
        </div>

        <!-- Form đổi mật khẩu -->
        <div class="form-section" id="change-password-form">
            <h2>Change Password</h2>
            <form action="" method="POST">
                <input type="hidden" name="change_password" value="1">
                <label for="current_password">Current Password:</label>
                <input type="password" name="current_password" id="current_password" required>

                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password" required>
                
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
                
                <button type="submit">Change Password</button>
            </form>
        </div>
    </div>

    <script>
        // JavaScript để hiển thị hoặc ẩn form khi người dùng nhấn nút
        document.getElementById('update-info-btn').addEventListener('click', function() {
            const updateForm = document.getElementById('update-info-form');
            const changePasswordForm = document.getElementById('change-password-form');
            
            // Chuyển form này thành trạng thái ngược lại
            updateForm.style.display = (updateForm.style.display === 'none' || updateForm.style.display === '') ? 'block' : 'none';
            // Ẩn form đổi mật khẩu
            changePasswordForm.style.display = 'none';
        });

        document.getElementById('change-password-btn').addEventListener('click', function() {
            const changePasswordForm = document.getElementById('change-password-form');
            const updateForm = document.getElementById('update-info-form');
            
            // Chuyển form này thành trạng thái ngược lại
            changePasswordForm.style.display = (changePasswordForm.style.display === 'none' || changePasswordForm.style.display === '') ? 'block' : 'none';
            // Ẩn form cập nhật thông tin
            updateForm.style.display = 'none';
        });
    </script>
</body>
</html>
