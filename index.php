<?php
session_start();
include 'include/config.php';
include 'include/index.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product | Shopping Cart</title>

    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/css/custom.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include 'include/menu.php'; ?>

    <div class="product-wrapper">
        <div class="container">
            <?php if (!empty($_SESSION['message'])): ?>
                <div class="alert alert-warning alert-dismissible fade show rounded-4 mb-4" role="alert">
                    <i class="bi bi-bell me-2"></i><?php echo $_SESSION['message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <!-- Carousel Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-body p-0">
                    <div id="carouselExampleIndicators" class="carousel slide rounded-4 overflow-hidden" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://cf.shopee.co.th/file/th-11134258-7rasb-m63nss8s7t861f_xxhdpi"
                                    class="d-block w-100" style="height: 400px; object-fit: cover;" alt="food-4">
                            </div>
                            <div class="carousel-item">
                                <img src="https://cf.shopee.co.th/file/th-11134258-7rash-m5caolszc9zx3f_xxhdpi"
                                    class="d-block w-100" style="height: 400px; object-fit: cover;" alt="food-1">
                            </div>
                            <div class="carousel-item">
                                <img src="https://cf.shopee.co.th/file/th-11134258-7ras9-m683qi4i4ywm33_xxhdpi"
                                    class="d-block w-100" style="height: 400px; object-fit: cover;" alt="food-6">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- filter food category-->
            <div class="mb-4">
                <h5 class="card-title mb-3">Category</h5>
                <div class="d-flex flex-wrap gap-2">
                    <?php while ($category = mysqli_fetch_assoc($categories_query)): ?>
                        <a href="?category=<?php echo $category['name']; ?>" 
                            class="btn btn-outline-primary <?php echo (isset($_GET['category']) && $_GET['category'] == $category['name']) || 
                            (!isset($_GET['category']) && $category['name'] == 'all') ? 'active' : ''; ?>">
                            <?php echo $category['display_name']; ?>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Products Section -->
            <div class="row g-4">
                <?php if ($rows > 0): ?>
                    <?php while ($product = mysqli_fetch_assoc($query)): ?>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="product-card card shadow-sm h-100">
                                <?php if (!empty($product['profile_image'])): ?>
                                    <img src="<?php echo $base_url; ?>/upload_image/<?php echo $product['profile_image']; ?>"
                                        class="card-img-top" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                <?php else: ?>
                                    <img src="<?php echo $base_url; ?>/assets/images/no-image.png" class="card-img-top"
                                        alt="No Image Available">
                                <?php endif; ?>

                                <div class="card-body d-flex flex-column">
                                    <h5 class="product-title"><?php echo $product['product_name']; ?></h5>
                                    <p class="price-tag mb-2">฿<?php echo number_format($product['price'], 2); ?></p>
                                    <p class="product-detail text-muted mb-4"><?php echo nl2br($product['detail']); ?></p>
                                    <a href="<?php echo $base_url; ?>/cart-add.php?id=<?php echo $product['id']; ?>"
                                        class="btn btn-primary btn-cart mt-auto">
                                        <i class="fa-solid fa-cart-plus me-2"></i>Add to Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <script src="<?php echo $base_url; ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo $base_url; ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>