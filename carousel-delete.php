<?php
include 'include/session-admin.php';
include 'include/config.php';

if (!empty($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    
    if ($id === false) {
        $_SESSION['message'] = 'Invalid carousel ID';
        header("location: {$base_url}/carousel.php");
        exit();
    }

    $stmt = mysqli_prepare($conn, "SELECT image FROM carousel WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $carousel = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($carousel) {
        $image_path = 'assets/images/carousel/' . $carousel['image'];
        if (!empty($carousel['image']) && file_exists($image_path)) {
            unlink($image_path);
        }

        $stmt = mysqli_prepare($conn, "DELETE FROM carousel WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($success) {
            $_SESSION['message'] = 'Carousel item deleted successfully';
        } else {
            $_SESSION['message'] = 'Error deleting carousel item: ' . mysqli_error($conn);
        }
    } else {
        $_SESSION['message'] = 'Carousel item not found';
    }

    mysqli_close($conn);
    header("location: {$base_url}/carousel.php");
    exit();
} else {
    $_SESSION['message'] = 'Invalid request';
    header("location: {$base_url}/carousel.php");
    exit();
}