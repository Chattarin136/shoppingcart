<?php
session_start();
include 'include/config.php';
include 'include/login.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login | Shopping Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="<?php echo $base_url; ?>/assets/css/custom.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="login-wrapper">
        <div class="container">
            <div class="justify-content-end row w-100 mx-auto">
                <div class="col-md-10 col-lg-4 mt-5">
                    <div class="text-center mb-4">
                        <img src="assets/images/cart-logo.svg" alt="Logo" class="brand-logo">
                        <h2 class="text-dark mb-2">Welcome Back!</h2>
                        <p class="text-muted">Please login to your account</p>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center mb-0">Login</h3>
                        </div>
                        <div class="card-body p-4">
                            <?php if ($error)
                                echo "<div class='alert alert-danger'><i class='bi bi-exclamation-triangle-fill me-2'></i>$error</div>"; ?>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control" id="password" name="password"
                                            required>
                                    </div>
                                </div>
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                    </button>
                                </div>
                                <div class="text-center mb-3">
                                    <a href="forgot-password.php" class="text-decoration-none">Forgot Password?</a>
                                </div>
                                <hr>
                                <div class="d-grid">
                                    <a href="/shoppingcart/register.php" class="btn btn-outline-secondary">
                                        <i class="bi bi-person-plus me-2"></i>Create New Account
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="index.php" class="text-decoration-none">
                            <i class="bi bi-arrow-left me-2"></i>Back to Shop
                        </a>
                    </div>
                </div>
                <div class="col-md-10 col-lg-6 d-none d-lg-block">
                    <img src="assets/images/shopping-cart.jpg" alt="Shopping Cart" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

</body>

</html>