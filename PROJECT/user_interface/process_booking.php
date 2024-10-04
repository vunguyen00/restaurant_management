<?php
include 'config/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_name'])) {
    $name = $_POST['name'];
    $table_id = $_POST['table'];
    $date = $_POST['date'];
    $people = $_POST['people'];
    $request = $_POST['request'];
    $user_id = $_SESSION['user_id']; // Lấy user_id từ session

    // Lưu thông tin đặt bàn vào bảng booking_history
    $sql_insert = "INSERT INTO booking_history (user_id, booking_code, booking_time, booking_day)
                   VALUES ('$user_id', UUID(), '$date', DATE('$date'))";
    if ($mysqli->query($sql_insert) === TRUE) {
        // Cập nhật trạng thái bàn thành "occupied"
        $sql_update_table = "UPDATE restaurant_table SET status = 'occupied' WHERE table_id = '$table_id'";
        $mysqli->query($sql_update_table);

        // Chuyển hướng về trang đặt bàn sau khi đặt bàn thành công
        echo "Booking successful!";
        header("Location: booking.php");
    } else {
        echo "Error: " . $sql_insert . "<br>" . $mysqli->error;
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
