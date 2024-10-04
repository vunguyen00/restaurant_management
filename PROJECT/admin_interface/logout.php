<?php
session_start();
session_unset();
session_destroy();

// Chuyển hướng về trang login bằng URL hợp lệ
header("Location: /restaurant_management/PROJECT/login.php"); // Sử dụng đường dẫn tương đối
exit();
?>
