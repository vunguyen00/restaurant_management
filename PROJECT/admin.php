<?php 
include("config/config.php");

// Lấy danh sách bàn từ cơ sở dữ liệu
$tablesQuery = "SELECT table_id, table_number FROM restaurant_table";
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
        </ul>
    </div>

    <div class="main-content">
        <div class="navbar">
            <a href="#">Home</a>
            <span>admin</span>
        </div>
        <button class="create-btn" id="openAddTableModal">Add Table</button>
        <button id="deleteTableBtn" class="create-btn">Delete Table</button>
        <button id="openMenuSelectionModal" class="create-btn">Select Dishes</button>
        <div class="dashboard">
            <div class="left-card-container">
                <div class="card-container">
                    <?php if ($tablesResult->num_rows > 0): ?>
                        <?php while ($table = $tablesResult->fetch_assoc()): ?>
                            <div class="card" data-id="<?php echo htmlspecialchars($table['table_id']); ?>">
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
                            <!-- Thêm input để chọn số lượng -->
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
            <span class="close" id="closeDeleteConfirmationModal">&times;</span>
            <h2>Confirm Delete</h2>
            <p>Are you sure you want to delete this table?</p>
            <button id="confirmDeleteBtn">Yes, Delete</button>
            <button id="cancelDeleteBtn">Cancel</button>
        </div>
    </div>

    <script>
        var addTableModal = document.getElementById("addTableModal");
        var openAddTableBtn = document.getElementById("openAddTableModal");
        var closeAddTableBtn = document.getElementById("closeAddTableModal");

        openAddTableBtn.onclick = function() {
            addTableModal.style.display = "block";
        }

        closeAddTableBtn.onclick = function() {
            addTableModal.style.display = "none";
        }

        var menuSelectionModal = document.getElementById("menuSelectionModal");
        var openMenuSelectionBtn = document.getElementById("openMenuSelectionModal");
        var closeMenuSelectionBtn = document.getElementById("closeMenuSelectionModal");

        openMenuSelectionBtn.onclick = function() {
            if (selectedTableId) {
                menuSelectionModal.style.display = "block";
            } else {
                alert("Please select a table first.");
            }
        }

        closeMenuSelectionBtn.onclick = function() {
            menuSelectionModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == addTableModal) {
                addTableModal.style.display = "none";
            }
            if (event.target == menuSelectionModal) {
                menuSelectionModal.style.display = "none";
            }
            if (event.target == deleteConfirmationModal) {
                deleteConfirmationModal.style.display = "none";
            }
        }

        var deleteConfirmationModal = document.getElementById("deleteConfirmationModal");
        var confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
        var cancelDeleteBtn = document.getElementById("cancelDeleteBtn");

        confirmDeleteBtn.onclick = function() {
            if (selectedTableId) {
                fetch('delete_table.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + encodeURIComponent(selectedTableId)
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    deleteConfirmationModal.style.display = "none";
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
            }
        }

        cancelDeleteBtn.onclick = function() {
            deleteConfirmationModal.style.display = "none";
        }

        document.getElementById("addTableForm").onsubmit = function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            fetch('add_table.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                addTableModal.style.display = "none";
                location.reload();
            })
            .catch(error => console.error('Error:', error));
        }

        var selectedTableId = null;

document.querySelectorAll(".card").forEach(card => {
    card.onclick = function() {
        document.querySelectorAll(".card").forEach(c => c.classList.remove('selected'));
        this.classList.add('selected');
        selectedTableId = this.getAttribute('data-id');

        // Cập nhật menu-container với các món ăn của bàn hiện tại
        updateMenuForTable(selectedTableId);
        
        // Cập nhật trạng thái bàn
        updateTableStatus(selectedTableId, 'occupied');
    }
});

function updateMenuForTable(tableId) {
    fetch('get_table_menu.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + encodeURIComponent(tableId)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateMenuContainer(data.dishes);
        } else {
            alert('Error loading dishes: ' + data.error);
        }
    })
    .catch(error => console.error('Error:', error));
}

document.getElementById("menuSelectionForm").onsubmit = function(event) {
    event.preventDefault();
    var formData = new FormData(this);
    formData.append('table_id', selectedTableId);

    fetch('update_table_menu.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateMenuForTable(selectedTableId);
            document.getElementById("menuSelectionModal").style.display = "none";
        } else {
            alert('Error updating dishes: ' + data.error);
        }
    })
    .catch(error => console.error('Error:', error));
}


function updateMenuContainer(dishes) {
    var selectedDishesList = document.getElementById("selectedDishesList");
    selectedDishesList.innerHTML = '';

    dishes.forEach(dish => {
        var li = document.createElement('li');
        li.textContent = dish.dish_name + ' (Quantity: ' + dish.quantity + ')';
        selectedDishesList.appendChild(li);
    });
}


function updateTableStatus(tableId, status) {
    fetch('update_table_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + encodeURIComponent(tableId) + '&status=' + encodeURIComponent(status)
    })
    .then(response => response.text())
    .then(data => {
        console.log('Table status updated:', data);
    })
    .catch(error => console.error('Error:', error));
}

            // Khi nhấn vào phần nền của modal, đóng modal
    window.onclick = function(event) {
        if (event.target === document.getElementById("menuSelectionModal")) {
            document.getElementById("menuSelectionModal").style.display = "none";
        }
    }
    
    </script>
</body>
</html>
