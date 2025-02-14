<?php
session_start();
include 'include/config.php';

$error = '';
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
        if ($stmt->num_rows > 0) $error = "Username already exists";
        $stmt->close();
    }
    
    if (empty($error)) {
        // Convert status to string for bind_param
        $status = (string)$status;
        
        $sql = "INSERT INTO users (username, `password`, `name`, surname, tel, email, `address`, `status`, reset_token, reset_expiry) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            die('Prepare failed: ' . $conn->error);
        }
        
        // Check if bind was successful
        if (!$stmt->bind_param("ssssssssss", 
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
        )) {
            die('Binding parameters failed: ' . $stmt->error);
        }

        // Execute and check result
        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }

        $user_id = $stmt->insert_id;
        $stmt->close();

        // Insert permission
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Registration Form</h2>
                        <?php if(!isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Surname</label>
                                <input type="text" class="form-control" name="surname" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tel</label>
                                <input type="text" class="form-control" name="tel" pattern="^0[689]\d{8}$" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                            <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>