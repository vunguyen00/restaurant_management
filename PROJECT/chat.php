<?php
session_start();
include 'config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Lấy danh sách người dùng để hiển thị trong dropdown
$users_result = $mysqli->query("SELECT user_id, user_name FROM user WHERE user_id != $user_id");
$users = $users_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .chat-container {
            background: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 320px;
            padding: 20px;
        }
        h1, h2 {
            font-size: 18px;
            margin-bottom: 15px;
        }
        h1 {
            color: #555;
        }
        #chat-box {
            width: 100%;
            height: 200px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow-y: auto;
            padding: 10px;
            margin-bottom: 10px;
            background: #fafafa;
        }
        .message {
            margin: 5px 0;
            font-size: 14px;
        }
        .message.sent {
            text-align: right;
            color: #007bff;
        }
        .message.received {
            text-align: left;
            color: #28a745;
        }
        select, textarea, button {
            width: 100%;
            font-size: 14px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 8px;
            outline: none;
        }
        select:focus, textarea:focus, button:focus {
            border-color: #007bff;
        }
        button {
            background: #007bff;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        textarea {
            resize: none;
            height: 50px;
        }
        label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }
    </style>
    <script>
        let selectedReceiverId = null;

        // Tải tin nhắn
        function loadMessages() {
            if (!selectedReceiverId) return;

            fetch(`load_messages.php?receiver_id=${selectedReceiverId}`)
                .then(response => response.json())
                .then(messages => {
                    const chatBox = document.getElementById('chat-box');
                    chatBox.innerHTML = '';
                    messages.forEach(msg => {
                        const div = document.createElement('div');
                        div.className = 'message ' + (msg.sender_id == <?php echo $user_id; ?> ? 'sent' : 'received');
                        div.textContent = `[${msg.sender_name}] ${msg.message_content}`;
                        chatBox.appendChild(div);
                    });
                    chatBox.scrollTop = chatBox.scrollHeight;
                });
        }

        // Gửi tin nhắn
        function sendMessage() {
            const messageContent = document.getElementById('message-content').value;

            if (!selectedReceiverId || !messageContent.trim()) return;

            fetch('send_message.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    sender_id: <?php echo $user_id; ?>,
                    receiver_id: selectedReceiverId,
                    message_content: messageContent
                })
            }).then(() => {
                loadMessages();
                document.getElementById('message-content').value = '';
            });
        }

        // Khi thay đổi người nhận
        function onReceiverChange() {
            selectedReceiverId = document.getElementById('receiver').value;
            loadMessages();
        }

        // Làm mới khung chat mỗi 5 giây
        setInterval(loadMessages, 5000);
    </script>
</head>
<body>
    
    <div class="chat-container">
        <h1>Chào, <?php echo $user_name; ?>!</h1>
        <h2>Nhắn tin</h2>

        <label>Chọn người nhận:</label>
        <select id="receiver" onchange="onReceiverChange()">
            <option value="">-- Chọn người --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo $user['user_id']; ?>"><?php echo $user['user_name']; ?></option>
            <?php endforeach; ?>
        </select>

        <div id="chat-box"></div>

        <textarea id="message-content" placeholder="Nhập tin nhắn..."></textarea>
        <button onclick="sendMessage()">Gửi</button>
        <button class="show-btn" id="back-btn" onclick="history.back()">Back</button>
    </div>
</body>
</html>
