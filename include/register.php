<?php

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $status = 1;
    $reset_token = NULL;
    $reset_expiry = NULL;

    if ($password != $confirm_password) {
        $error = "Password and Confirm Password do not match";
    } else if ($stmt = $conn->prepare("SELECT id FROM users WHERE username = ?")) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0)
            $error = "Username already exists";
        $stmt->close();
    }

    if (empty($error)) {
        $status = (string) $status;

        $sql = "INSERT INTO users (username, `password`, `name`, surname, tel, email, `address`, `status`, reset_token, reset_expiry) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die('Prepare failed: ' . $conn->error);
        }

        if (
            !$stmt->bind_param(
                "ssssssssss",
                $username,
                password_hash($password, PASSWORD_DEFAULT),
                $name,
                $surname,
                $tel,
                $email,
                $address,
                $status,
                $reset_token,
                $reset_expiry
            )
        ) {
            die('Binding parameters failed: ' . $stmt->error);
        }

        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }

        $user_id = $stmt->insert_id;
        $stmt->close();
        $sql = "INSERT INTO permission_users (user_id, `role`) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $role = 'customer';
        $stmt->bind_param("is", $user_id, $role);
        $stmt->execute();
        $stmt->close();

        header("Location: login.php");
        exit();
    }
}
?>