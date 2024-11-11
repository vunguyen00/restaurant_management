<?php
include 'config/config.php';
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: ../login.php"); // Chuyển hướng về trang đăng nhập nếu chưa đăng nhập
    exit();
}

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (isset($_SESSION['user_name'])) {
    $userName = $_SESSION['user_name'];  // Lấy tên người dùng từ session
} else {
    $userName = "USER"; 
}

// Truy vấn để lấy tên món, giá, mô tả, nguyên liệu và ID món
$sql = "SELECT menu.dish_id, menu.dish_name, menu.price, menu.dish_describe, menu.image_path,
        GROUP_CONCAT(ingredients.ingredient_name SEPARATOR ', ') AS ingredients
        FROM menu
        LEFT JOIN dish_ingredients ON menu.dish_id = dish_ingredients.dish_id
        LEFT JOIN ingredients ON dish_ingredients.ingredient_id = ingredients.ingredient_id
        GROUP BY menu.dish_id";
$result = $mysqli->query($sql);

if (!$result) {
    die("Truy vấn thất bại: " . $mysqli->error);
}

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Tính tổng số lượng và tổng giá tiền
$totalQuantity = 0;
$totalPrice = 0;

foreach ($_SESSION['cart'] as $item) {
    if (isset($item['quantity']) && isset($item['price'])) {
        $totalQuantity += $item['quantity'];
        $totalPrice += $item['price'] * $item['quantity'];
    }
}

// Lưu trữ danh sách món ăn cho giỏ hàng
$cartItems = [];
foreach ($_SESSION['cart'] as $item) {
    if (isset($item['dish_name']) && isset($item['price'])) {
        $cartItems[] = $item;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order for user</title>
    <link rel="stylesheet" href="order.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.order-btn').click(function(e) {
            e.preventDefault(); // Prevent default form submission behavior

            var form = $(this).closest('form');
            var dish_id = form.find('input[name="dish_id"]').val();
            var quantity = form.find('input[name="quantity"]').val();

            $.ajax({
                type: 'POST',
                url: 'cart.php', // URL to handle cart updates
                data: { dish_id: dish_id, quantity: quantity },
                success: function(response) {
                    // Parse the response from the server
                    var result = JSON.parse(response);
                    
                    if (result.error) {
                        alert(result.error); // Display an error if something goes wrong
                    } else {
                        // Directly append the item to the cart without needing to reload
                        $('#cart-items').append('<tr><td>' + result.dish_name + '</td><td>' + quantity + '</td><td>$' + result.price.toFixed(2) + '</td></tr>');

                        // Update cart item count and total price
                        $('#cart-count').text(parseInt($('#cart-count').text()) + parseInt(quantity));
                        $('#total-price').text('$' + (parseFloat($('#total-price').text().replace('$', '')) + (result.price * quantity)).toFixed(2));
                    }
                },
                error: function() {
                    alert("Error occurred. Please try again.");
                }
            });
        });
    });
    </script>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="logo">
            <h1 style="color: #ff9900;">Restaurant</h1>
        </div>
        <div class="nav-links">
            <a href="HomePage.php">HOME</a>
            <a href="about.php">ABOUT</a>
            <a href="booking.php">BOOKING</a>
            <a href="history2.php">VIEW BOOKING HISTORY</a>
            <a href="order.php">DISHES</a>
            <a href="history.php">BILL</a>
            <div class="dropdown">
                <a href="#" class="user-btn"><?php echo htmlspecialchars($userName); ?></a>
                <div class="dropdown-content">
                    <a href="logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Hiển thị danh sách món ăn -->
    <div class="container">
        <?php while($row = $result->fetch_assoc()): ?>
        <div class="item">
            <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Food Image" width="200">
            <h3><?php echo htmlspecialchars($row['dish_name']); ?> <span class="price">$<?php echo htmlspecialchars($row['price']); ?></span></h3>
            <p><?php echo htmlspecialchars($row['dish_describe']); ?></p>
        </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
