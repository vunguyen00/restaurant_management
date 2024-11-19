<?php 
include ("config/config.php");
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

// Get list of tables from the database
$tablesQuery = "SELECT table_id, table_number,status FROM restaurant_table";
$tablesResult = $mysqli->query($tablesQuery);

// Get list of dishes from the database
$menuQuery = "SELECT * FROM menu";
$menuResult = $mysqli->query($menuQuery);

// Get list of admins from the database
$adminQuery = "SELECT user_name FROM user WHERE role = 1";
$adminResult = $mysqli->query($adminQuery);
$admins = [];
if ($adminResult->num_rows > 0) {
    while ($row = $adminResult->fetch_assoc()) {
        $admins[] = $row['user_name'];
    }
}

// Get list of users for chat
$userQuery = "SELECT user_name FROM user WHERE role != 1"; // Exclude admins
$userResult = $mysqli->query($userQuery);
$users = [];
if ($userResult->num_rows > 0) {
    while ($row = $userResult->fetch_assoc()) {
        $users[] = $row['user_name'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>LOGO</h2>
        <ul>
            <li><a href="admin.php">Home</a></li>
            <li><a href="admins.php">Admins</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="foods.php">Foods</a></li>
            <li><a href="books.php">Bookings</a></li>
            <li><a href="statistics.php" class="button">Revenue & Dish Statistics</a></li>
            <li><a href="statistical.php">Revenue Statistics</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="navbar">
            <a href="#">HOME</a>
            <div class="dropdown">
                <a href="#" class="user-btn"><?php echo htmlspecialchars($userName); ?></a>
                <div class="dropdown-content">
                    <a href="logout.php">Log Out</a>
                    <a href="../information.php">Information</a>
                </div>
            </div>
        </div>
        <button class="create-btn" id="openAddTableModal">Add Table</button>
        <button id="deleteTableBtn" class="create-btn">Delete Table</button>
        <button id="openMenuSelectionModal" class="create-btn">Select Dishes</button>
        
        <div class="dashboard">
            <div class="left-card-container">
                <div class="card-container">
                    <?php if ($tablesResult->num_rows > 0): ?>
                        <?php while ($table = $tablesResult->fetch_assoc()): ?>
                            <div class="card <?php echo ($table['status'] == 'occupied') ? 'occupied' : ($table['status'] == 'booked' ? 'booked' : ''); ?>" 
                                data-id="<?php echo htmlspecialchars($table['table_id']); ?>">
                                <h3>Table <?php echo htmlspecialchars($table['table_number']); ?></h3>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No tables found.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="menu-container" id="menuContainer">
                <center><h2>Selected dishes</h2></center>
                <ul id="selectedDishesList"></ul>
                <button id="checkoutBtn" class="create-btn">Checkout</button>
                <button id="cancelOrderBtn" class="create-btn">Cancel Order</button>

                <div id="receiptModal" class="modal">
                    <div class="modal-content">
                        <span class="close" id="closeReceiptModal">&times;</span>
                        <h3 style="
                                    text-align: center;
                                    margin-bottom: 20px; color: #ff9900">Receipt</h3>
                        <ul id="receiptList"></ul>
                        <p>Total: <span id="totalAmount"></span></p>
                        
                        <h4 style="margin-top: 20px;
                                    font-size: 1.2em;">Customer Information</h4>
                        <label for="customer_name">Name:</label>
                        <input type="text" id="customer_name" placeholder="Enter customer name" required>
                        <p></p>
                        <label for="customer_phone">Phone:</label>
                        <input type="text" id="customer_phone" placeholder="Enter customer phone" required>
                        
                        <button id="confirmCheckoutBtn">Confirm Checkout</button>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu tượng nhắn tin -->
    <div class="chat-icon" id="chatIcon">&#128172;</div>

    <!-- Giao diện nhắn tin -->
    <div class="message-container" id="messageContainer">
        <div class="message-header" id="messageHeader">Chat with User</div>
        <div class="message-content" id="messageContent">
            <!-- Messages will display here -->
        </div>
        <label for="userSelect">Select User:</label>
        <select id="userSelect">
            <option value="">Select a user</option>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo htmlspecialchars($user); ?>"><?php echo htmlspecialchars($user); ?></option>
            <?php endforeach; ?>
        </select>
        <form class="message-form" id="messageForm">
            <input type="text" id="messageInput" placeholder="Type your message..." required>
            <button type="submit">Send</button>
        </form>
    </div>

    <!-- Các Modal -->
    <!-- Add Table Modal -->
    <div id="addTableModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeAddTableModal">&times;</span>
            <h2>Add Table</h2>
            <form id="addTableForm">
                <div class="form-group">
                    <label for="table_number">Table Number:</label>
                    <input type="number" id="table_number" name="table_number" required>
                </div>
                <button type="submit">Add Table</button>
            </form>
        </div>
    </div>

    <!-- Menu Selection Modal -->
    <div id="menuSelectionModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeMenuSelectionModal">&times;</span>
            <h2>Select Dishes</h2>
            <form id="menuSelectionForm">
                <?php if ($menuResult->num_rows > 0): ?>
                    <?php while ($dish = $menuResult->fetch_assoc()): ?>
                        <div class="menu-item">
                            <div style="display:flex;">
                                <img src="<?php echo htmlspecialchars($dish['image_path']); ?>" alt="Food Image" width="100">
                                <div style="margin-left: 15px;">   
                                    <label>
                                        <input type="checkbox" name="dishes[]" value="<?php echo htmlspecialchars($dish['dish_id']); ?>">
                                        <?php echo htmlspecialchars($dish['dish_name']); ?>
                                    </label>
                                    <h3>Mô tả món ăn: <span style="font-weight: normal;"><?php echo htmlspecialchars($dish['dish_describe']); ?></span></h3>

                                    <h3>Số lượng: <input type="number" name="quantities[<?php echo htmlspecialchars($dish['dish_id']); ?>]" min="1" value="1" style="width: 60px;">
                                    </div></h3>
                                </div>
                            </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No dishes found.</p>
                <?php endif; ?>
                <button type="submit">Confirm Selection</button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmationModal" class="modal">
        <div class="modal-content">
            <h2>Confirm Delete</h2>
            <p>Are you sure you want to delete this table?</p>
            <button id="confirmDeleteBtn">Yes, Delete</button>
            <button id="cancelDeleteBtn">Cancel</button>
        </div>
    </div>

    <!-- JavaScript Files -->
    <script src="deleteX.js"></script>
    <script src="dashboard.js"></script>    
</body>
</html>