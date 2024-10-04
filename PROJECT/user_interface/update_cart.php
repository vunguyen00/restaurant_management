<?php
session_start();
if (isset($_POST['dish_id'])) {
    $dish_id = $_POST['dish_id'];
    // Tăng số lượng món ăn trong giỏ hàng
    if (isset($_SESSION['cart'][$dish_id])) {
        $_SESSION['cart'][$dish_id]['quantity']++;
    }
}
header('Location: cart.php');
exit;
?>
