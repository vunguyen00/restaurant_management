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
$sql = "SELECT menu.dish_id, menu.dish_name, menu.price, menu.dish_describe, 
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

        // Cart checkout handling
        // Sự kiện thanh toán
        $('#checkout-btn').click(function() {
            // Kiểm tra giỏ hàng trước khi thanh toán
            if ($('#cart-items tr').length === 0) {
                alert("Giỏ hàng của bạn đang trống.");
                return;
            }

            // Hiển thị xác nhận trước khi thanh toán
            let confirmation = confirm("Bạn có chắc chắn muốn thanh toán?");
            if (confirmation) {
                // Chuyển hướng đến trang thanh toán nếu người dùng xác nhận
                $.ajax({
                    type: 'POST',
                    url: 'checkout.php', // Gửi yêu cầu đến checkout.php để lưu đơn hàng
                    success: function(response) {
                        alert("Đơn hàng của bạn đã được lưu!");
                        window.location.href = 'history.php'; // Điều hướng đến trang lịch sử đơn hàng nếu muốn
                    },
                    error: function() {
                        alert("Có lỗi xảy ra trong quá trình thanh toán.");
                    }
                });
            }
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
            <a href="order.php">ORDER</a>
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
            <img src="images/<?php echo strtolower($row['dish_name']); ?>.jpg" alt="<?php echo $row['dish_name']; ?>">
            <h3><?php echo htmlspecialchars($row['dish_name']); ?> <span class="price">$<?php echo htmlspecialchars($row['price']); ?></span></h3>
            <p><strong>Ingredients:</strong> <?php echo htmlspecialchars($row['ingredients']); ?></p>
            <p><?php echo htmlspecialchars($row['dish_describe']); ?></p>
            <form>
                <input type="hidden" name="dish_id" value="<?php echo $row['dish_id']; ?>">
                <input type="hidden" name="quantity" value="1"> <!-- Mặc định số lượng là 1 -->
                <button type="submit" class="order-btn">ORDER</button>
            </form>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- Hiển thị giỏ hàng -->
    <div class="cart-toggle" id="cart-toggle">
        🛒
    </div>

    <!-- Hiển thị giỏ hàng -->
    <div class="cart" id="cart">
        <div class="cart-header">
            <h2>Your Cart</h2>
            <span id="close-cart" style="cursor: pointer; float: right; color:black;">✖</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Dish Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody id="cart-items">
                <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['dish_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><strong>Total: <span id="total-price">$<?php echo number_format($totalPrice, 2); ?></span></strong></p>
        <button id="checkout-btn" style="background-color: #ff9900; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">Thanh Toán</button>
    </div>

    <script>
        // JavaScript để xử lý mở/đóng giỏ hàng
        document.getElementById('cart-toggle').addEventListener('click', function() {
            var cart = document.getElementById('cart');
            cart.style.display = (cart.style.display === 'none' || cart.style.display === '') ? 'block' : 'none';
        });

        document.getElementById('close-cart').addEventListener('click', function() {
            document.getElementById('cart').style.display = 'none';
        });
        
    </script>
</body>
</html>
