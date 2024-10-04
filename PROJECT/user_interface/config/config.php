<?php
// Thay đổi các thông tin dưới đây để phù hợp với cấu hình của bạn
$host = "localhost";
$username = "root";
$password = "";
$database = "restaurantdb";

$mysqli = new mysqli($host, $username, $password, $database);

// Kiểm tra kết nối
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
