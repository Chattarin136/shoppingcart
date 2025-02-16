<?php
session_start();
include 'include/config.php';
include 'include/register.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Shopping Cart</title>
    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="<?php echo $base_url; ?>/assets/css/custom.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="login-wrapper">
        <div class="container">
            <div class="justify-content-center row w-100 mx-auto">
                <div class="col-md-10 col-lg-4 mt-5">
                    <div class="text-center mb-4">
                        <img src="assets/images/lock.png" alt="Logo" class="brand-logo">
                        <h2 class="text-dark mb-2">Create Account</h2>
                        <p class="text-muted">Please fill in your information</p>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center mb-0">Create Account</h3>
                        </div>
                        <div class="card-body p-4">
                            <?php if (!isset($error))
                                echo "<div class='alert alert-danger'><i class='bi bi-exclamation-triangle-fill me-2'></i>$error</div>"; ?>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <?php if (!empty($error)): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($error); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control" name="username" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" class="form-control" name="confirm_password" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Surname</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                                        <input type="text" class="form-control" name="surname" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tel</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="text" class="form-control" name="tel" pattern="^0[689]\d{8}$"
                                            required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-house"></i></span>
                                        <textarea rows="4" cols="50" class="form-control" name="address"
                                            required></textarea>
                                    </div>
                                </div>
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-person-plus me-2"></i>Register
                                    </button>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="login.php" class="text-decoration-none">
                                        Already have an account? Login here
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
            </div>
        </div>
    </div>

    
    <script src="<?php echo $base_url; ?>/assets/js/bootstrap.min.js"></script>
</body>

</html>