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
                            <?php if (!empty($table['table_id'])): ?>
                                data-id="<?php echo htmlspecialchars($table['table_id']); ?>"
                            <?php endif; ?>>
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
                <!-- Nút thanh toán -->
                <button id="checkoutBtn" class="create-btn">Checkout</button>
                <!-- Receipt Modal -->
                <!-- Receipt Modal -->
                <div id="receiptModal" class="modal">
                    <div class="modal-content">
                        <span class="close" id="closeReceiptModal">&times;</span> <!-- Nút để đóng modal -->
                        <h3>Receipt</h3>
                        <ul id="receiptList"></ul>
                        <p>Total: <span id="totalAmount"></span></p>
                        
                        <!-- Thêm thông tin khách hàng -->
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
    <script src="deleteX.js"></script>
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
                    body: 'table_id=' + encodeURIComponent(selectedTableId) // Sử dụng đúng `table_id`
                })
                .then(response => response.json()) // Giả sử `delete_table.php` trả về JSON
                .then(data => {
                    if (data.success) {
                        alert('Table deleted successfully');
                        deleteConfirmationModal.style.display = "none";
                        location.reload(); // Reload lại trang sau khi xóa thành công
                    } else {
                        alert('Error deleting table: ' + data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        };

        
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

// Thêm chức năng khi nhấn vào nút "Delete Table"
var deleteTableBtn = document.getElementById("deleteTableBtn");
deleteTableBtn.onclick = function() {
    if (selectedTableId) {
        deleteConfirmationModal.style.display = "block"; // Hiển thị modal xác nhận
    } else {
        alert("Please select a table first.");
    }
};

function updateMenuForTable(tableId) {
    fetch('get_table_menu.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'table_id=' + encodeURIComponent(tableId)  // Gửi table_id thay vì order_id
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
            // Cập nhật danh sách món ăn ngay sau khi thêm món
            updateMenuForTable(selectedTableId);
            document.getElementById("menuSelectionModal").style.display = "none";
            location.reload();
        } else {
            alert('Error updating dishes: ' + data.error);
        }
    })
    .catch(error => console.error('Error:', error));
}



function updateMenuContainer(dishes) {
    var selectedDishesList = document.getElementById("selectedDishesList");
    selectedDishesList.innerHTML = ''; // Xóa nội dung hiện tại

    dishes.forEach(dish => {
        var li = document.createElement('li');
        li.textContent = dish.dish_name + ' (Quantity: ' + dish.quantity + ', Price: $' + dish.price + ')';

        // Thêm nút xóa món
        var removeButton = document.createElement('button');
        removeButton.textContent = 'Remove';
        removeButton.classList.add('remove-btn');
        removeButton.onclick = function() {
            removeDishFromOrder(dish.dish_id, dish.quantity);
        };

        // Thêm nút xóa vào list item
        li.appendChild(removeButton);
        selectedDishesList.appendChild(li); // Thêm món vào danh sách
    });
}





// Tính tổng tiền khi nhấn nút Checkout
// Đặt biến cho các thành phần
var receiptModal = document.getElementById("receiptModal");
var closeReceiptModalBtn = document.getElementById("closeReceiptModal");

// Hàm để đóng modal khi nhấn vào dấu "X"
closeReceiptModalBtn.onclick = function() {
    receiptModal.style.display = "none";
};

// Tính tổng tiền khi nhấn nút Checkout
var checkoutBtn = document.getElementById("checkoutBtn");
// Tính tổng tiền khi nhấn nút Checkout
checkoutBtn.onclick = function() {
    if (selectedTableId) {
        // First, get the table menu
        fetch('get_table_menu.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'table_id=' + encodeURIComponent(selectedTableId)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Generate the receipt
                generateReceipt(data.dishes);

                // Hiển thị modal xác nhận checkout
                receiptModal.style.display = "block";  // Hiển thị modal để xác nhận thanh toán
            } else {
                throw new Error('Error generating receipt: ' + data.error);
            }
        })
        .catch(error => alert(error.message));
};

    document.getElementById("confirmCheckoutBtn").onclick = function() {
        const customerName = document.getElementById("customer_name").value;
        const customerPhone = document.getElementById("customer_phone").value;

        // Kiểm tra thông tin khách hàng
        if (!customerName || !customerPhone) {
            alert("Vui lòng điền thông tin khách hàng.");
            return;
        }

        // Tiến hành thanh toán
        fetch('checkout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'table_id=' + encodeURIComponent(selectedTableId) +
                '&customer_name=' + encodeURIComponent(customerName) +
                '&customer_phone=' + encodeURIComponent(customerPhone)
        })
        .then(response => {
            if (response.ok) {
                return response.text(); // Nhận HTML
            } else {
                throw new Error('Lỗi trong quá trình thanh toán');
            }
        })
        .then(html => {
            // Hiển thị hóa đơn
            document.body.innerHTML = html; // Thay đổi nội dung body thành hóa đơn
        })
        .catch(error => alert(error.message));
    };

}

function generateReceipt(dishes) {
    var receiptList = document.getElementById("receiptList");
    var totalAmount = document.getElementById("totalAmount");
    receiptList.innerHTML = '';
    let total = 0;
    dishes.forEach(dish => {
        var li = document.createElement('li');
        var dishTotal = dish.quantity * dish.price;
        li.textContent = dish.dish_name + ' x' + dish.quantity + ' = $' + dishTotal.toFixed(2);
        receiptList.appendChild(li);
        total += dishTotal;
    });
    totalAmount.textContent = '$' + total.toFixed(2);
    receiptModal.style.display = "block";
}
document.addEventListener('DOMContentLoaded', function () {
        var userBtn = document.querySelector('.user-btn');
        var dropdownContent = document.querySelector('.dropdown-content');

        userBtn.addEventListener('click', function (e) {
            e.preventDefault();
            dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
        });
        window.addEventListener('click', function (e) {
            if (!userBtn.contains(e.target) && !dropdownContent.contains(e.target)) {
                dropdownContent.style.display = 'none';
            }
        });
    });
    function removeDishFromOrder(dishId, quantity) {
        fetch('remove_dish.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'table_id=' + encodeURIComponent(selectedTableId) + '&dish_id=' + encodeURIComponent(dishId) + '&quantity=' + encodeURIComponent(quantity)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Dish removed successfully');
                updateMenuForTable(selectedTableId); // Làm mới danh sách món ăn sau khi xóa
            } else {
                alert('Error removing dish: ' + data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function clearTable(tableId) {
        fetch('clear_table.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'table_id=' + encodeURIComponent(tableId)
        })
        .then(response => response.text())
        .then(data => {
            console.log('Table cleared:', data);
            updateTableStatus(tableId, 'empty');
            updateMenuForTable(tableId); 
        })
        .catch(error => console.error('Error:', error));
    }

    function updateTableStatus(tableId, status) {
        fetch('update_table_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'table_id=' + encodeURIComponent(tableId) + '&status=' + encodeURIComponent(status)
        })
        .then(response => response.text())
        .then(data => {
            console.log('Table status updated:', data);
        })
        .catch(error => console.error('Error:', error));
    }
    window.onclick = function(event) {
        if (event.target === receiptModal) {
            receiptModal.style.display = "none";
        }
    };
    </script>
</body>
</html>