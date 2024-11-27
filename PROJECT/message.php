<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống nhắn tin</title>
</head>
<body>
    <h1>Gửi tin nhắn</h1>
    <form action="send_message.php" method="POST">
        <label>Người gửi (ID):</label><br>
        <input type="number" name="sender_id" required><br>
        <label>Người nhận (ID):</label><br>
        <input type="number" name="receiver_id" required><br>
        <label>Nội dung:</label><br>
        <textarea name="message_content" required></textarea><br>
        <button type="submit">Gửi</button>
    </form>

    <h1>Xem tin nhắn</h1>
    <form action="view_messages.php" method="GET">
        <label>ID người dùng:</label><br>
        <input type="number" name="user_id" required><br>
        <button type="submit">Xem</button>
    </form>
</body>
</html>
