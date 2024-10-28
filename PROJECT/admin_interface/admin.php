<?php 
include ("config/config.php");
session_start();
if (isset($_SESSION['user_name'])) {
    $userName = $_SESSION['user_name'];  // Lấy tên người dùng từ session
} else {
    $userName = "USER"; 
}

// Lấy danh sách bàn từ cơ sở dữ liệu
$tablesQuery = "SELECT table_id, table_number,status FROM restaurant_table";
$tablesResult = $mysqli->query($tablesQuery);

// Lấy danh sách món ăn từ cơ sở dữ liệu
$menuQuery = "SELECT dish_id, dish_name FROM menu";
$menuResult = $mysqli->query($menuQuery);
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
        </ul>
    </div>

    <div class="main-content">
        <div class="navbar">
            <a href="#">Home</a>
            <div class="dropdown">
                <a href="#" class="user-btn"><?php echo htmlspecialchars($userName); ?></a>
                <div class="dropdown-content">
                    <a href="logout.php">Log Out</a>
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
                            <div class="card <?php echo ($table['status'] == 'occupied') ? 'occupied' : ''; ?>"
                                 data-id="<?php echo htmlspecialchars($table['table_id']); ?>">
                                <!-- Nếu bàn đã có người ngồi, hiển thị nút “+” để mở menu selection modal -->
                                <?php if ($table['status'] == 'occupied'): ?>
                                    <button class="join-btn" data-id="<?php echo htmlspecialchars($table['table_id']); ?>">+</button>
                                <?php endif; ?>
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
                <!-- Menu items will be loaded here -->
                <ul id="selectedDishesList"></ul>
                <!-- Checkout Button -->
                <button id="checkoutBtn" class="create-btn">Checkout</button>

                <!-- Receipt Modal -->
                <div id="receiptModal" class="modal">
                    <div class="modal-content">
                        <span class="close" id="closeReceiptModal">&times;</span> <!-- Close button for modal -->
                        <h3>Receipt</h3>
                        <ul id="receiptList"></ul>
                        <p>Total: <span id="totalAmount"></span></p>
                        
                        <!-- Customer Information -->
                        <h4>Customer Information</h4>
                        <label for="customer_name">Name:</label>
                        <input type="text" id="customer_name" placeholder="Enter customer name" required>
                        
                        <label for="customer_phone">Phone:</label>
                        <input type="text" id="customer_phone" placeholder="Enter customer phone" required>
                        
                        <button id="confirmCheckoutBtn">Confirm Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            <label>
                                <input type="checkbox" name="dishes[]" value="<?php echo htmlspecialchars($dish['dish_id']); ?>">
                                <?php echo htmlspecialchars($dish['dish_name']); ?>
                            </label>
                            <!-- Input for quantity -->
                            <input type="number" name="quantities[<?php echo htmlspecialchars($dish['dish_id']); ?>]" min="1" value="1" style="width: 60px;">
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
    
    <script>
        // Mở modal chọn món khi nhấn nút "+"
        document.querySelectorAll('.join-btn').forEach(button => {
            button.addEventListener('click', function () {
                // Mở modal chọn món
                document.getElementById('menuSelectionModal').style.display = 'block';
            });
        });

        // Đóng modal chọn món
        document.getElementById('closeMenuSelectionModal').onclick = () => {
            document.getElementById('menuSelectionModal').style.display = 'none';
        };
    </script>
</body>
</html>
