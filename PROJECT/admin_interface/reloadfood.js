// Example function to place an order and update ingredient quantities
function placeOrder(dishId, quantityOrdered) {
    $.ajax({
        type: "POST",
        url: "admin.php",
        data: {
            dish_id: dishId,
            quantity: quantityOrdered
        },
        success: function(response) {
            alert(response);
            location.reload();
        },
        error: function(xhr, status, error) {
            alert("An error occurred: " + error);
        }
    });
}

// Example usage: Call the placeOrder function when an "Order" button is clicked
$('.order-btn').click(function() {
    var dishId = $(this).data('id');
    var quantityOrdered = 1; // You can get this from an input field if needed
    placeOrder(dishId, quantityOrdered);
});
