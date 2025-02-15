<header class="container-fluid bg-light">
    <div class="d-flex justify-content-between align-items-center py-3">
        <!-- Center menu items -->
        <div class="flex-grow-1 text-center">
            <ul class="nav nav-pills justify-content-center">
                <li class="nav-item"><a href="<?php echo $base_url; ?>/manage-product.php" class="nav-link <?php echo ($_SESSION['role'] ?? '') !== 'admin' ? 'd-none' : ''; ?>">Admin</a></li>
                <li class="nav-item"><a href="<?php echo $base_url; ?>/order.php" class="nav-link <?php echo ($_SESSION['role'] ?? '') !== 'admin' ? 'd-none' : ''; ?>">Order</a></li>
                <li class="nav-item"><a href="<?php echo $base_url; ?>/index.php" class="nav-link <?php echo ($_SESSION['role'] ?? '') !== 'admin' ? 'd-none' : ''; ?>">Product List</a></li>
            </ul>
        </div>
        
        <!-- Right-aligned user menu -->
        <div>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="<?php echo $base_url; ?>/cart.php" class="nav-link">
                        <i class="fas fa-shopping-cart text-dark"></i>
                        <span class="badge bg-dark rounded-pill"><?php echo count($_SESSION['cart'] ?? []); ?></span>
                    </a>
                </li>
                <?php if(isset($_SESSION['username'])) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark d-flex align-items-center" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i>
                            <span><?php echo htmlspecialchars($_SESSION['name']) . " " . htmlspecialchars($_SESSION['surname']); ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo $base_url; ?>/profile.php">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?php echo $base_url; ?>/logout.php">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a href="<?php echo $base_url; ?>/login.php" class="btn btn-dark">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</header>
