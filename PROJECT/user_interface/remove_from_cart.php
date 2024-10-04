<?php
session_start();
if (isset($_POST['dish_id'])) {
    $dish_id = $_POST['dish_id'];
    // Giảm số lượng hoặc xóa món khỏi giỏ hàng
    if (isset($_SESSION['cart'][$dish_id])) {
        if ($_SESSION['cart'][$dish_id]['quantity'] > 1) {
            $_SESSION['cart'][$dish_id]['quantity']--;
        } else {
            unset($_SESSION['cart'][$dish_id]); // Xóa món khỏi giỏ nếu số lượng về 0
        }
    }
}
header('Location: cart.php');
exit;
?>
