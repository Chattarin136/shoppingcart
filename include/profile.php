<?php

if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $name = $_POST['name']; 
    $surname = $_POST['surname'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $user_id = $_SESSION['id'];

    $sql = "UPDATE users SET 
            username = ?, 
            name = ?, 
            surname = ?, 
            tel = ?, 
            email = ?, 
            address = ? 
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $username, $name, $surname, $tel, $email, $address, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Profile updated successfully";
    } else {
        $_SESSION['error'] = "Something went wrong";
    }
}

// Get current user data
$user_id = $_SESSION['id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE Id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

?>