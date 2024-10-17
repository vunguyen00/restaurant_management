<?php
session_start();
session_unset();
session_destroy();

// Chuyển hướng về trang login bằng URL hợp lệ
header("Location: ../login.php"); // Sử dụng đường dẫn tương đối
exit();
?>
