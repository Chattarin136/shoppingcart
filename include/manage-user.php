<?php
$query = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
$rows = mysqli_num_rows($query);

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE Id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$query_product = mysqli_stmt_get_result($stmt);

// Fix query result handling
$row_product = mysqli_fetch_assoc($query_product);

if($row_product == 0 && isset($_GET['id'])) {
    header('location:' . $base_url . '/manage-user.php');
    exit();
}

?>