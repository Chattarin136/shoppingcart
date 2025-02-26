<?php
include 'include/session-admin.php';
include 'include/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
    $discount_value = filter_input(INPUT_POST, 'discount_value', FILTER_VALIDATE_FLOAT);
    $promotion_text = filter_input(INPUT_POST, 'promotion_text', FILTER_SANITIZE_STRING);
    $status = 1;
    // Validate required fields
    if (!$code || !$discount_value || !$promotion_text || !isset($status)) {
        $_SESSION['message'] = "All fields are required";
        $_SESSION['message_type'] = "danger";
        header("Location: promotion.php");
        exit();
    }

    // Validate discount value range
    if ($discount_value < 0 || $discount_value > 99999) {
        $_SESSION['message'] = "Invalid discount value";
        $_SESSION['message_type'] = "danger";
        header("Location: promotion.php");
        exit();
    }

    try {
        // Check if code already exists (for new promotions)
        if (!$id) {
            $check_stmt = $conn->prepare("SELECT id FROM promocodes WHERE code = ?");
            $check_stmt->bind_param("s", $code);
            $check_stmt->execute();
            if ($check_stmt->get_result()->num_rows > 0) {
                throw new Exception("Promotion code already exists");
            }
            $check_stmt->close();
        }

        if ($id) {
            // Update existing promotion
            $stmt = $conn->prepare("UPDATE promocodes SET code = ?, discount_value = ?, promotion_text = ?, status = ? WHERE id = ?");
            $stmt->bind_param("sdsii", $code, $discount_value, $promotion_text, $status, $id);
            $action = "updated";
        } else {
            // Create new promotion
            $stmt = $conn->prepare("INSERT INTO promocodes (code, discount_value, promotion_text, status) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sdsi", $code, $discount_value, $promotion_text, $status);
            $action = "created";
        }

        if ($stmt->execute()) {
            $_SESSION['message'] = "Promotion successfully " . $action;
            $_SESSION['message_type'] = "success";
        } else {
            throw new Exception("Error processing promotion");
        }

        $stmt->close();
        
    } catch (Exception $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
    }

    header("Location: promotion.php");
    exit();
} else {
    // If not POST request, redirect to manage page
    header("Location: promotion.php");
    exit();
}
?>