<?php
session_start();
include 'include/config.php';
include 'include/forgot-password.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Shopping Cart</title>
    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="<?php echo $base_url; ?>/assets/css/custom.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="login-wrapper">
        <div class="container">
            <div class="justify-content-end row w-100 mx-auto">
                <div class="col-md-10 col-lg-6 d-none d-lg-block">
                    <img src="assets/images/shopping-forgot.png" alt="Shopping Cart" class="img-fluid">
                </div>
                <div class="col-md-10 col-lg-4 forgot-password">
                    <div class="text-center mb-4">
                        <img src="assets/images/question-mark.png" alt="Logo" class="brand-logo">
                        <h2 class="text-dark mb-2">Forgot Password?</h2>
                        <p class="text-muted">Enter your email to reset password</p>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center mb-0">Reset Password</h3>
                        </div>
                        <div class="card-body p-4">
                            <?php if ($error)
                                echo "<div class='alert alert-danger'><i class='bi bi-exclamation-triangle-fill me-2'></i>$error</div>"; ?>

                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" name="email" required>
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