<?php
include("config/config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $message = $mysqli->real_escape_string($input['message']);
    $toUser = $mysqli->real_escape_string($input['to']);
    $fromUser = $_SESSION['user_name'];

    // Insert the message into the database
    $query = "INSERT INTO messages (from_user, to_user, message) VALUES ('$fromUser', '$toUser', '$message')";
    if ($mysqli->query($query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $mysqli->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
