<?php
session_start();
include 'include/config.php';
include 'include/cart.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/css/cart.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/solid.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-body-tertiary">
    <?php include 'include/menu.php'; ?>
    <div class="container" style="margin-top: 30px;">
        <?php if(!empty($_SESSION['message'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-12">
                <form action="<?php echo $base_url; ?>/cart-update.php" method="post">
                    <?php if($rows > 0): ?>
                        <div class="row">
                            <div class="col-md-8">
                                <?php while($product = mysqli_fetch_assoc($query)): ?>
                                    <div class="card mb-3 shadow-sm">
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <?php if(!empty($product['profile_image'])): ?>
                                                    <img src="<?php echo $base_url; ?>/upload_image/<?php echo $product['profile_image']; ?>" 
                                                        class="img-fluid rounded-start" alt="Product Image">
                                                <?php else: ?>
                                                    <img src="<?php echo $base_url; ?>/assets/images/no-image.png" 
                                                        class="img-fluid rounded-start" alt="Product Image">
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                                                        <a onclick="return confirm('Are your sure you want to delete?');" 
                                                            href="<?php echo $base_url; ?>/cart-delete.php?id=<?php echo $product['id']; ?>" 
                                                            class="text-danger">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </div>
                                                    <p class="card-text"><small class="text-muted"><?php echo nl2br($product['detail']); ?></small></p>
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <p class="mb-0">Price: ฿<?php echo number_format($product['price'], 2); ?></p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-text">Qty</span>
                                                                <input type="number" 
                                                                    name="product[<?php echo $product['id']; ?>][quantity]" 
                                                                    value="<?php echo $_SESSION['cart'][$product['id']]; ?>" 
                                                                    min="1" max="99" 
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p class="mb-0 text-end">Total: ฿<?php echo number_format($product['price'] * $_SESSION['cart'][$product['id']], 2); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                                <div class="text-end mt-4 mb-4">
                                    <a href="index.php" class="text-decoration-none">
                                        <i class="bi bi-arrow-left me-2"></i>Back to home
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">Cart Summary</h5>
                                        <hr>
                                        <div class="mb-3">
                                            <label for="promocode" class="form-label">Promotion Code</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="promocode" name="promocode" placeholder="Enter code" value="<?php echo !empty($_SESSION['promocode']) ? $_SESSION['promocode']['code'] : ''; ?>">
                                                <button class="btn btn-outline-secondary" type="submit" id="apply-promocode">Apply</button>
                                            </div>
                                            <!-- promotion_text -->
                                            <?php if(!empty($_SESSION['promocode'])): ?>
                                                <p class="text-danger mt-2"><?php echo $_SESSION['promocode']['promotion_text']; ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <hr>
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-success">Update Cart</button>
                                            <button type="button" class="btn btn-primary">Checkout Order</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center py-5">
                                <i class="fa-solid fa-shopping-cart fa-4x text-muted mb-4"></i>
                                <h4 class="mb-3">Your Cart is Empty</h4>
                                <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
                                <a href="index.php" class="btn btn-primary">
                                    <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>


    <script src="<?php echo $base_url; ?>/assets/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.btn-primary:contains("Checkout Order")').click(function(e) {
                e.preventDefault();
                <?php if(isset($_SESSION['username'])) : ?>
                    window.location.href = '<?php echo $base_url; ?>/checkout.php';
                <?php else : ?>
                    alert('Please login before checkout.');
                    window.location.href = '<?php echo $base_url; ?>/login.php';
                <?php endif; ?>
            });
        });
    </script>
</body>
</html>