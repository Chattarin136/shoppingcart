<?php
include 'include/session-admin.php';
include 'include/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['message'] = 'Invalid request method';
    header("location: {$base_url}/carousel.php");
    exit();
}

$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
$status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT) ?? 1;
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);


if (empty($title) || empty($description)) {
    $_SESSION['message'] = 'Title and description are required';
    header("location: {$base_url}/carousel.php");
    exit();
}

$image_name = '';
$upload_dir = 'assets/images/carousel/';
$max_file_size = 2 * 1024 * 1024; // 2MB

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    if ($_FILES['image']['size'] > $max_file_size) {
        $_SESSION['message'] = 'File size exceeds 2MB limit';
        header("location: {$base_url}/carousel.php");
        exit();
    }

    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $file_type = $_FILES['image']['type'];
    
    if (in_array($file_type, $allowed_types)) {
        $image_name = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "", basename($_FILES['image']['name']));
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = $upload_dir . $image_name;
        
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0777, true)) {
                $_SESSION['message'] = 'Failed to create upload directory';
                header("location: {$base_url}/carousel.php");
                exit();
            }
        }
    } else {
        $_SESSION['message'] = 'Invalid file type. Only JPG, JPEG and PNG are allowed';
        header("location: {$base_url}/carousel.php");
        exit();
    }
}

try {
    if (empty($id)) {
        if (empty($image_name)) {
            $_SESSION['message'] = 'Image is required for new carousel items';
            header("location: {$base_url}/carousel.php");
            exit();
        }

        $stmt = mysqli_prepare($conn, "INSERT INTO carousel (title, description, image, status) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssi", $title, $description, $image_name, $status);
    } else {
        $stmt = mysqli_prepare($conn, "SELECT image FROM carousel WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $old_image = mysqli_fetch_assoc($result)['image'];
        mysqli_stmt_close($stmt);

        if (empty($image_name)) {
            $image_name = $old_image;
        } else {
            $old_image_path = $upload_dir . $old_image;
            if (!empty($old_image) && file_exists($old_image_path)) {
                unlink($old_image_path);
            }
        }

        $stmt = mysqli_prepare($conn, "UPDATE carousel SET title=?, description=?, image=?, status=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "sssii", $title, $description, $image_name, $status, $id);
    }

    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($success) {
        if (isset($image_tmp) && isset($image_path)) {
            if (!move_uploaded_file($image_tmp, $image_path)) {
                $_SESSION['message'] = 'Failed to upload image file';
                header("location: {$base_url}/carousel.php");
                exit();
            }
        }
        $_SESSION['message'] = 'Carousel saved successfully!';
    } else {
        $_SESSION['message'] = 'Error saving carousel: ' . mysqli_error($conn);
    }

} catch (Exception $e) {
    $_SESSION['message'] = 'Error: ' . $e->getMessage();
}

mysqli_close($conn);
header("location: {$base_url}/carousel.php");
exit();
