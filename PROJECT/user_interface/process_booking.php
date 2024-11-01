<?php
include 'config/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_name'])) {
    $name = $_POST['name'];
    $table_id = $_POST['table'];
    $table_number = $_POST['table_number'];
    $date = $_POST['date'];
    $request = $_POST['request'];  // Capture special request
    $user_id = $_SESSION['user_id'];

    $bookingTime = new DateTime($date);
    $now = new DateTime();

    if ($bookingTime < (clone $now)->modify('+1 hour')) {
        die("Bạn cần đặt bàn trong khoảng 1 giờ sau thời gian hiện tại.");
    }

    if ($bookingTime < (clone $now)->modify('+5 hours')) {
        $sql_check_table = "SELECT status, user_id FROM restaurant_table WHERE table_id = '$table_id'";
        $result_check_table = $mysqli->query($sql_check_table);
        
        if ($result_check_table && $result_check_table->num_rows > 0) {
            $row = $result_check_table->fetch_assoc();
            if ($row['status'] != 'empty' && $row['user_id'] != $user_id) {
                die("Bàn đã được đặt hoặc không còn trống.");
            }
        } else {
            die("Bàn không tồn tại.");
        }
    }

    // Include special request in the INSERT statement
    $sql_insert = "INSERT INTO booking_history (user_id, table_id, table_number, booking_code, booking_time, booking_day, special_request)
                   VALUES ('$user_id', '$table_id', '$table_number', UUID(), '{$bookingTime->format('Y-m-d H:i:s')}', DATE('{$bookingTime->format('Y-m-d')}'), '$request')";

    if ($mysqli->query($sql_insert) === TRUE) {
        $sql_update_table = "UPDATE restaurant_table SET status = 'booked', user_id = '$user_id' WHERE table_id = '$table_id'";
        $mysqli->query($sql_update_table);

        header("Location: booking.php");
        exit();
    } else {
        echo "Error: " . $sql_insert . "<br>" . $mysqli->error;
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
