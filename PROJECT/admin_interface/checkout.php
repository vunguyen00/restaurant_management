<?php
include 'config/config.php';
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_SESSION['user_name'])) {
    $userName = $_SESSION['user_name'];  // Get user name from session
    $userRoleQuery = "SELECT role FROM user WHERE user_name = '$userName'";
    $roleResult = $mysqli->query($userRoleQuery);
    $userRole = $roleResult->fetch_assoc()['role'];
} else {
    $userName = "USER"; 
}

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if request is POST and table_id is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table_id'])) {
    $table_id = $_POST['table_id'];
    $total_price = 0; // Initialize total price

    // Lấy user_id từ session
    $user_id = $_SESSION['user_id']; // Giả sử bạn đã lưu user_id vào session

    // Begin transaction
    $mysqli->begin_transaction();

    try {
        // Retrieve the selected dishes for the table
        $query = "SELECT dish_id, quantity FROM table_orders WHERE table_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $table_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Create an array to hold order items
        $order_items = [];

        while ($row = $result->fetch_assoc()) {
            $dish_id = $row['dish_id'];
            $quantity = $row['quantity'];

            // Get the dish name from dishes
            $dishQuery = "SELECT dish_name FROM menu WHERE dish_id = ?";
            $dishStmt = $mysqli->prepare($dishQuery);
            $dishStmt->bind_param("i", $dish_id);
            $dishStmt->execute();
            $dishResult = $dishStmt->get_result();
            $dish = $dishResult->fetch_assoc();

            if (!$dish) {
                throw new Exception("Dish not found for dish ID: $dish_id");
            }

            // Get the price from menu
            $priceQuery = "SELECT price FROM menu WHERE dish_id = ?";
            $priceStmt = $mysqli->prepare($priceQuery);
            $priceStmt->bind_param("i", $dish_id);
            $priceStmt->execute();
            $priceResult = $priceStmt->get_result();
            $priceData = $priceResult->fetch_assoc();

            if (!$priceData) {
                throw new Exception("Price not found for dish ID: $dish_id");
            }
            $price = $priceData['price']; // Get price from menu

            // Calculate total price
            $total_price += $price * $quantity;

            // Add to order items array
            $order_items[] = [
                'dish_name' => $dish['dish_name'],
                'quantity' => $quantity,
                'price' => $price,
            ];
        }

        // Lấy thông tin khách hàng từ POST
        $customer_name = $_POST['customer_name'];
        $customer_phone = $_POST['customer_phone'];

        // Create a new order in the orders table
        $insertOrderQuery = "INSERT INTO orders (user_id, total_price, payment_time, order_date, table_id, customer_name, customer_phone) VALUES (?, ?, NOW(), NOW(), ?, ?, ?)";
        $insertOrderStmt = $mysqli->prepare($insertOrderQuery);
        $insertOrderStmt->bind_param("idiss", $user_id, $total_price, $table_id, $customer_name, $customer_phone);
        
        if (!$insertOrderStmt->execute()) {
            throw new Exception("Error creating order: " . $insertOrderStmt->error);
        }

        // Get the last inserted order ID
        $order_id = $insertOrderStmt->insert_id;

        // Insert each order item into order_items table
        foreach ($order_items as $item) {
            $insertItemQuery = "INSERT INTO order_items (order_id, dish_name, quantity, price) VALUES (?, ?, ?, ?)";
            $insertItemStmt = $mysqli->prepare($insertItemQuery);
            $insertItemStmt->bind_param("isid", $order_id, $item['dish_name'], $item['quantity'], $item['price']);
            
            if (!$insertItemStmt->execute()) {
                throw new Exception("Error inserting order item: " . $insertItemStmt->error);
            }
        }

        // Clear the table orders after checkout
        $clearTableQuery = "DELETE FROM table_orders WHERE table_id = ?";
        $clearStmt = $mysqli->prepare($clearTableQuery);
        $clearStmt->bind_param("i", $table_id);
        $clearStmt->execute();
        
        // Check if clear operation was successful
        if ($clearStmt->affected_rows === 0) {
            throw new Exception("Failed to clear table orders for table ID: $table_id");
        }

        // Update table status to empty
        $updateStatusQuery = "UPDATE restaurant_table SET status = 'empty' WHERE table_id = ?";
        $updateStatusStmt = $mysqli->prepare($updateStatusQuery);
        $updateStatusStmt->bind_param("i", $table_id);
        $updateStatusStmt->execute();

        // Commit transaction
        $mysqli->commit();

        // Hiển thị hóa đơn dưới dạng HTML
        echo '<html>
        <head>
            <title>Hóa Đơn</title>
            <style>
    
                .bill {
                    width: 60%;
                    margin: 50px auto;
                    padding: 20px;
                    background-color: #ffffff;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                    border-radius: 8px;
                }
                .bill h2 {
                    text-align: center;
                    font-size: 24px;
                    color: #ff9900;
                    margin-bottom: 20px;
                }
                .bill p {
                    font-size: 16px;
                    margin: 10px 0;
                }
                .bill table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                    font-family: Arial, sans-serif;
                    background-color: #f8f9fa;
                    border-radius: 8px; /* Round corners for table */
                    overflow: hidden; /* To hide overflow for rounded corners */
                }
                .bill th, .bill td {
                    padding: 12px;
                    text-align: left;
                    border: 1px solid #ddd;
                }           
                .bill table th {
                    background-color: #ff9900;
                    color: white;
                    font-weight: bold;
                }
                .bill td {
                    padding: 10px;
                    text-align: left;
                    font-size: 15px;
                    color: #555;
                }
                .bill button {
                    margin-top: 20px;
                    padding: 10px 20px;
                    background-color: #ff9900;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    font-size: 16px;
                    cursor: pointer;
                }
                .bill button:hover {
                    background-color: #e68a00;
                }
            </style>

        </head>
        <body>
            <div class="bill">
                <h2>Hóa Đơn</h2>
                <p><strong>Mã Đơn Hàng:</strong> ' . $order_id . '</p>
                <p><strong>Ca thanh toán:</strong> ' . $userName . '</p>
                <p><strong>Tên Khách Hàng:</strong> ' . $customer_name . '</p>
                <p><strong>Số Điện Thoại:</strong> ' . $customer_phone . '</p>
                <p><strong>Tổng Tiền:</strong> ' . number_format($total_price, 2) . ' VNĐ</p>
                <h3>Món ăn:</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Tên Món</th>
                            <th>Số Lượng</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody>';
    
    foreach ($order_items as $item) {
        echo '<tr>
                <td>' . htmlspecialchars($item['dish_name']) . '</td>
                <td>' . htmlspecialchars($item['quantity']) . '</td>
                <td>' . number_format($item['price'], 2) . ' VNĐ</td>
            </tr>';
    }
    
    echo '      </tbody>
                </table>
                <button onclick="window.print();">In Hóa Đơn</button>
                <button onclick="window.location.href=\'admin.php\';">Quay lại Admin</button>
            </div>
        </body>
    </html>';
    
    } catch (Exception $e) {
        $mysqli->rollback();
        error_log("Transaction failed: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request or missing table ID']);
}

// Close the connection
$mysqli->close();
?>