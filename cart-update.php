<?php
session_start();
include 'include/config.php';

$promocode = $_POST['promocode'];

foreach($_SESSION['cart'] as $productId => $productQty) {
    $_SESSION['cart'][$productId] = $_POST['product'][$productId]['quantity'];
}

$_SESSION['message'] = 'Cart update success';

// check promocode
$query = mysqli_query($conn, "SELECT * FROM promocodes WHERE code = '{$promocode}' AND `status` = 1") or die('query failed');
if(mysqli_num_rows($query) > 0) {
    $promocode = mysqli_fetch_assoc($query);
    $_SESSION['promocode'] = $promocode;
    $_SESSION['promotion_text'] = $promocode['promotion_text'];
} else if (empty($promocode)) {
    unset($_SESSION['promocode']);
}

header('location: ' . $base_url . '/cart.php');