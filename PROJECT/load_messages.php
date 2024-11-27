<?php
include 'config/config.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_GET['receiver_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Thông tin không hợp lệ.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$receiver_id = $_GET['receiver_id'];

$stmt = $mysqli->prepare('
    SELECT m.message_id, m.sender_id, m.receiver_id, m.message_content, u1.user_name AS sender_name
    FROM messages m
    JOIN user u1 ON m.sender_id = u1.user_id
    WHERE (m.sender_id = ? AND m.receiver_id = ?)
       OR (m.sender_id = ? AND m.receiver_id = ?)
    ORDER BY m.sent_at ASC
');
$stmt->bind_param('iiii', $user_id, $receiver_id, $receiver_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($messages);
?>
