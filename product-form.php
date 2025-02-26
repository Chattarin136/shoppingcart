<?php
include 'include/session.php';
include 'include/config.php';

$product_name = trim($_POST['product_name']);
$price = $_POST['price'] ?: 0;
$category = trim($_POST['category']);
$detail = trim($_POST['detail']);
$image_name = $_FILES['profile_image']['name'];
$image_tmp = $_FILES['profile_image']['tmp_name'];
$folder = 'upload_image/';
$image_location = $folder . $image_name;

if(empty($_POST['id'])) {
    $stmt = mysqli_prepare($conn, "INSERT INTO products (product_name, price, category, profile_image, detail) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sdsss", $product_name, $price, $category, $image_name, $detail);
    $query = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
} else {
    $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $_POST['id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if(empty($image_name)) {
        $image_name = $result['profile_image'];
    } else {
        @unlink($folder . $result['profile_image']);
    }

    $stmt = mysqli_prepare($conn, "UPDATE products SET product_name=?, price=?, category=?, profile_image=?, detail=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sdsssi", $product_name, $price, $category, $image_name, $detail, $_POST['id']);
    $query = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
if($query) {
    move_uploaded_file($image_tmp, $image_location);

    $_SESSION['message'] = 'Product Saved success';
    header('location: ' . $base_url . '/manage-product.php');
} else {
    $_SESSION['message'] = 'Product could not be saved!';
    header('location: ' . $base_url . '/manage-product.php');
}
