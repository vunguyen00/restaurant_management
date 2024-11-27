<?php
include 'config/config.php';
session_start();

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['user_id'], $data['receiver_id'], $data['message_content'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Dữ liệu không hợp lệ.']);
    exit;
}

$sender_id = $_SESSION['user_id'];
$receiver_id = $data['receiver_id'];
$message_content = $data['message_content'];

$stmt = $mysqli->prepare('INSERT INTO messages (sender_id, receiver_id, message_content) VALUES (?, ?, ?)');
$stmt->bind_param('iis', $sender_id, $receiver_id, $message_content);
$stmt->execute();

echo json_encode(['success' => true]);
?>
