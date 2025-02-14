<?php
include 'include/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $email, $id);

    if ($stmt->execute()) {
        header("Location: profile.php?success=1");
    } else {
        header("Location: profile.php?error=1");
    }
    exit();
}
?>