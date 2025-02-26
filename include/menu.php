<header class="container-fluid bg-light">
    <div class="d-flex justify-content-between align-items-center py-3">
        <!-- Center menu items -->
        <div class="flex-grow-1 text-center">
            <ul class="nav nav-pills justify-content-center">
                <!-- Admin dropdown menu -->
                <?php if(($_SESSION['role'] ?? '') === 'admin'): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                        <i class="fas fa-cog me-1"></i>Admin Panel
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo $base_url; ?>/manage-product.php">
                            <i class="fas fa-box me-2"></i>Manage Products</a>
                        </li>
                        <li><a class="dropdown-item" href="<?php echo $base_url; ?>/carousel.php">
                            <i class="fas fa-images me-2"></i>Manage Carousel</a>
                        </li>
                        <li><a class="dropdown-item" href="<?php echo $base_url; ?>/manage-user.php">
                            <i class="fas fa-users me-2"></i>Manage Users</a>
                        </li>
                        <li><a class="dropdown-item" href="<?php echo $base_url; ?>/promotion.php">
                            <i class="fas fa-gift me-2"></i>Manage Promotion</a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo $base_url; ?>/order.php">
                            <i class="fas fa-shopping-bag me-2"></i>Report Orders</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $base_url; ?>/index.php" class="nav-link">
                    <i class="fas fa-store me-1"></i>Shop</a>
                </li>
                <?php endif; ?>
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
                        <a class="nav-link dropdown-toggle text-dark align-items-center" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                            <i class="fas fa-user-circle fa-lg"></i>
                            <!-- <span class="d-none d-lg-block d-xl-block"><?php echo htmlspecialchars($_SESSION['name']) . " " . htmlspecialchars($_SESSION['surname']); ?></span> -->
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo $base_url; ?>/profile.php">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo $base_url; ?>/profile.php"><i class="fas fa-dollar-sign"></i> Point <span class="badge bg-dark rounded-pill"> <?php echo number_format($_SESSION['point']); ?></span></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?php echo $base_url; ?>/logout.php">
                                <i class="fas fa-sign-out-alt fa-lg me-1"></i>Logout
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
