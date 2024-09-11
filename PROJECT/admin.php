<?php 
include("config/config.php");

// Lấy danh sách bàn từ cơ sở dữ liệu
$tablesQuery = "SELECT table_id, table_number FROM restaurant_table";
$tablesResult = $mysqli->query($tablesQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        .card {
            padding: 20px;
            margin: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: inline-block;
            width: 150px;
            text-align: center;
            cursor: pointer;
            position: relative;
        }
        .card.selected {
            background-color: #f0f8ff;
        }
        .card-container {
            margin-bottom: 20px;
        }
        .menu-items {
            display: none;
            margin-top: 20px;
        }
        .menu-items.active {
            display: block;
        }
        .actions {
            margin-bottom: 20px;
        }
        .actions button {
            margin-right: 10px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
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

        <div class="dashboard">
            <button id="openAddTableModal">Add Table</button>
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

            <div class="actions">
                <button id="deleteTableBtn">Delete Table</button>
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

        window.onclick = function(event) {
            if (event.target == addTableModal) {
                addTableModal.style.display = "none";
            }
        }
        var deleteConfirmationModal = document.getElementById("deleteConfirmationModal");
        var closeDeleteConfirmationBtn = document.getElementById("closeDeleteConfirmationModal");
        var confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
        var cancelDeleteBtn = document.getElementById("cancelDeleteBtn");

        closeDeleteConfirmationBtn.onclick = function() {
            deleteConfirmationModal.style.display = "none";
        }

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

        window.onclick = function(event) {
            if (event.target == deleteConfirmationModal) {
                deleteConfirmationModal.style.display = "none";
            }
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

                // Show menu items or other details
                // document.querySelector(".menu-items").classList.add('active');
            }
        });
        document.getElementById("deleteTableBtn").onclick = function() {
            if (selectedTableId) {
                deleteConfirmationModal.style.display = "block";
            } else {
                alert("Please select a table first.");
            }
        }
    </script>
</body>
</html>
