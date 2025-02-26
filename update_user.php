<?php
include 'include/session-admin.php';
include 'include/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $points = filter_input(INPUT_POST, 'point', FILTER_VALIDATE_INT);

    if ($id === false || $points === false || $points < 0 || $points > 5000) {
        $_SESSION['message'] = "Invalid input data";
        header("Location: manage-user.php");
        exit();
    }

    try {
        $sql = "UPDATE users SET points = ? WHERE Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $points, $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "User points updated successfully";
            header("Location: manage-user.php");
        } else {
            throw new Exception("Error updating user");
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
        header("Location: manage-user.php");
    } finally {
        $stmt->close();
        exit();
    }
} else {
    header("Location: manage-user.php");
    exit();
}
?>