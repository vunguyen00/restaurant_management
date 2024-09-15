document.getElementById("checkoutBtn").onclick = function() {
    if (selectedTableId) {
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
                displayReceipt(data.dishes);
            } else {
                alert('Error loading dishes: ' + data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        alert("Please select a table first.");
    }
};

function displayReceipt(dishes) {
    var receiptModal = document.getElementById("receiptModal");
    var receiptList = document.getElementById("receiptList");
    var totalAmount = document.getElementById("totalAmount");
    
    receiptList.innerHTML = '';
    var total = 0;

    dishes.forEach(dish => {
        var li = document.createElement('li');
        var itemTotal = dish.quantity * dish.price;
        total += itemTotal;
        li.textContent = `${dish.dish_name} (Quantity: ${dish.quantity}) - $${itemTotal.toFixed(2)}`;
        receiptList.appendChild(li);
    });

    totalAmount.textContent = `$${total.toFixed(2)}`;
    receiptModal.style.display = "block";
}

// Close the modal when the user clicks on <span> (x)
document.getElementById("closeReceiptModal").onclick = function() {
    document.getElementById("receiptModal").style.display = "none";
}

// Close the modal when the user clicks anywhere outside of the modal
window.onclick = function(event) {
    if (event.target === document.getElementById("receiptModal")) {
        document.getElementById("receiptModal").style.display = "none";
    }
}