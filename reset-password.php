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
</head>
<body>
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
</body>
</html>