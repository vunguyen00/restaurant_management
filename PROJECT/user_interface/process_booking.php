<?php
include 'config/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_name'])) {
    $name = $_POST['name'];
    $table_id = $_POST['table']; // Lấy table_id từ form
    $table_number = $_POST['table_number']; // Lấy table_number từ form
    $date = $_POST['date']; // Lấy ngày từ biểu mẫu
    $time = ''; // Nếu bạn không cần thời gian, hãy bỏ qua
    $request = $_POST['request'];
    $user_id = $_SESSION['user_id']; // Lấy user_id từ session

    // Kết hợp ngày và giờ thành một datetime
    $bookingTime = new DateTime($date);

    // Lấy thời gian hiện tại
    $now = new DateTime();

    // Kiểm tra nếu thời gian đặt bàn ít nhất 1 giờ sau thời gian hiện tại
    if ($bookingTime < (clone $now)->modify('+1 hour')) {
        die("Bạn cần đặt bàn ít nhất 1 giờ sau thời gian hiện tại.");
    }

    // Nếu thời gian đặt bàn là sau 5 giờ, cho phép đặt bất kỳ bàn nào
    if ($bookingTime >= (clone $now)->modify('+5 hours')) {
        // Thực hiện lưu booking mà không cần kiểm tra trạng thái bàn
    } else {
        // Nếu không, chỉ cho phép đặt bàn còn trống
        // Kiểm tra trạng thái bàn
        $sql_check_table = "SELECT status FROM restaurant_table WHERE table_id = '$table_id'";
        $result_check_table = $mysqli->query($sql_check_table);
        
        if ($result_check_table && $result_check_table->num_rows > 0) {
            $row = $result_check_table->fetch_assoc();
            if ($row['status'] != 'empty') {
                die("Bàn đã được đặt hoặc không còn trống.");
            }
        } else {
            die("Bàn không tồn tại.");
        }
    }

    // Lưu thông tin đặt bàn vào bảng booking_history
    $sql_insert = "INSERT INTO booking_history (user_id, table_id, table_number, booking_code, booking_time, booking_day)
    VALUES ('$user_id', '$table_id', '$table_number', UUID(), '{$bookingTime->format('Y-m-d H:i:s')}', DATE('{$bookingTime->format('Y-m-d')}'))";

    if ($mysqli->query($sql_insert) === TRUE) {
        // Cập nhật trạng thái bàn thành "occupied"
        $sql_update_table = "UPDATE restaurant_table SET status = 'occupied' WHERE table_id = '$table_id'";
        $mysqli->query($sql_update_table);

        // Chuyển hướng về trang đặt bàn sau khi đặt bàn thành công
        header("Location: booking.php");
        exit(); // Đảm bảo dừng lại sau khi chuyển hướng
    } else {
        echo "Error: " . $sql_insert . "<br>" . $mysqli->error;
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
