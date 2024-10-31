<?php
include("config/config.php");

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['message']) && isset($data['to'])) {
    $message = $mysqli->real_escape_string($data['message']);
    $to = $mysqli->real_escape_string($data['to']);
    
    // Insert the message into the database (assuming you have a table called messages)
    $query = "INSERT INTO messages (sender, receiver, message) VALUES ('$userName', '$to', '$message')";
    if ($mysqli->query($query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $mysqli->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}
?>
