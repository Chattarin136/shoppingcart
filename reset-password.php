<?php
session_start();
include 'include/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $token = $_GET['token'];
    
    // Verify token and expiry
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        $_SESSION['error'] = "Invalid or expired reset token";
        header("Location: login.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match";
        header("Location: reset-password.php?token=" . $token);
        exit();
    }
    
    // Update password and clear reset token
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expiry = NULL WHERE reset_token = ?");
    $stmt->bind_param("ss", $hashed_password, $token);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Password has been reset successfully";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="<?php echo $base_url; ?>/assets/css/custom.css" rel="stylesheet">
</head>
<!-- <body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Reset Password</div>
                    <div class="card-body">
                        <?php if(isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?php 
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-1">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary mt-3">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body> -->
<body class="bg-light">
    <div class="login-wrapper">
        <div class="container">
            <div class="justify-content-center row w-100 mx-auto">
                <div class="col-md-10 col-lg-4 forgot-password">
                    <div class="text-center mb-4">
                        <img src="assets/images/question-mark.png" alt="Logo" class="brand-logo">
                        <h2 class="text-dark mb-2">Reset Password</h2>
                        <p class="text-muted">Enter your new Passsword</p>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center mb-0">Reset Password</h3>
                        </div>
                        <div class="card-body p-4">
                            <?php if(isset($_SESSION['error'])): ?>
                                <div class="alert alert-danger">
                                    <?php 
                                        echo $_SESSION['error'];
                                        unset($_SESSION['error']);
                                    ?>
                                </div>
                            <?php endif; ?>
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="mb-4">
                                    <label for="password" class="form-label">New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                            </form>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="login.php" class="text-decoration-none">
                            <i class="bi bi-arrow-left me-2"></i>Back to Shop
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>