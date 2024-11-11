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
function updateMenuContainer(dishes, tableId) {
var selectedDishesList = document.getElementById("selectedDishesList");
selectedDishesList.innerHTML = ''; // Clear current content

dishes.forEach(dish => {
    var li = document.createElement('li');
    li.textContent = dish.dish_name + ' (Quantity: ' + dish.quantity + ', Price: $' + dish.price + ')';

    // Add remove button
    var removeButton = document.createElement('button');
    removeButton.textContent = 'Remove';
    removeButton.classList.add('remove-btn');
    removeButton.onclick = function() {
        removeDishFromOrder(selectedTableId, dish.dish_name);
    };

    // Append the remove button to the list item
    li.appendChild(removeButton);
    selectedDishesList.appendChild(li); // Add dish to the list
});
}

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
function removeDishFromOrder(tableId, dishName) {
console.log('Removing dish:', { tableId, dishName }); // Log tham số để kiểm tra

// Gọi đến remove_dish.php với tên món ăn
fetch('remove_dish.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'table_id=' + encodeURIComponent(tableId) +
        '&dish_name=' + encodeURIComponent(dishName) // Truyền tên món ăn
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        alert('Món đã được xóa thành công');
        updateMenuForTable(tableId);
        location.reload();
    } else {
        alert('Lỗi khi xóa món: ' + data.error);
    }
})
.catch(error => console.error('Lỗi:', error));
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
        // Close the menu selection modal
        document.getElementById('closeMenuSelectionModal').onclick = () => {
            document.getElementById('menuSelectionModal').style.display = 'none';
        };

        // Handle cancel order button
        document.getElementById("cancelOrderBtn").addEventListener("click", function () {
            const selectedTable = document.querySelector(".card.selected");
            if (selectedTable) {
                const tableId = selectedTable.getAttribute("data-id");
                const confirmation = confirm("Are you sure you want to cancel the order for this table?");
                
                if (confirmation) {
                    fetch("cancel_order.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ table_id: tableId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Check response
                        if (data.success) {
                            alert("Order cancelled successfully.");
                            location.reload();
                        } else {
                            alert("Failed to cancel the order: " + data.error);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("An error occurred. Please try again.");
                    });
                }
            } else {
                alert("Please select a table to cancel the order.");
            }
        });