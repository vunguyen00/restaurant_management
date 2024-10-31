<?php
include("config/config.php"); // Kết nối đến cơ sở dữ liệu

// Kiểm tra xem các tham số đã được truyền vào hay chưa
if (isset($_GET['user']) && isset($_GET['current_user'])) {
    $user = $mysqli->real_escape_string($_GET['user']);
    $currentUser = $mysqli->real_escape_string($_GET['current_user']);

    // Lấy tin nhắn giữa hai người dùng
    $query = "
        SELECT sender, receiver, message, created_at 
        FROM messages 
        WHERE (sender = '$currentUser' AND receiver = '$user') 
           OR (sender = '$user' AND receiver = '$currentUser')
        ORDER BY created_at ASC";
    
    $result = $mysqli->query($query);
    $messages = [];

    // Lưu kết quả vào mảng JSON
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $messages[] = [
                'from' => $row['sender'],
                'to' => $row['receiver'],
                'text' => $row['message'],
                'time' => $row['created_at']
            ];
        }
    }

    // Trả về JSON
    echo json_encode(['success' => true, 'messages' => $messages]);
} else {
    echo json_encode(['success' => false, 'error' => 'Missing parameters.']);
}
?>
