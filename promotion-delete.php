<?php
include 'include/session-admin.php';
include 'include/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$id) {
        $_SESSION['message'] = "Invalid promotion ID";
        $_SESSION['message_type'] = "danger";
        header("Location: promotion.php");
        exit();
    }

    try {
        $stmt = $conn->prepare("DELETE FROM promocodes WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Promotion successfully deleted";
            $_SESSION['message_type'] = "success";
        } else {
            throw new Exception("Error deleting promotion");
        }

        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
    }

    header("Location: promotion.php");
    exit();
} else {
    header("Location: promotion.php");
    exit();
}
?>