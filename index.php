<?php
session_start();
include 'include/config.php';
include 'include/index.php';

// Get active carousel items
$carousel_query = mysqli_query($conn, "SELECT * FROM carousel WHERE status = 1 ORDER BY id DESC");
$carousel_items = mysqli_fetch_all($carousel_query, MYSQLI_ASSOC);
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
                            <?php foreach ($carousel_items as $index => $item): ?>
                                <button type="button" 
                                        data-bs-target="#carouselExampleIndicators" 
                                        data-bs-slide-to="<?php echo $index; ?>"
                                        <?php echo $index === 0 ? 'class="active" aria-current="true"' : ''; ?>
                                        aria-label="Slide <?php echo $index + 1; ?>">
                                </button>
                            <?php endforeach; ?>
                        </div>
                        <div class="carousel-inner">
                            <?php foreach ($carousel_items as $index => $item): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <img src="<?php echo $base_url; ?>/assets/images/carousel/<?php echo $item['image']; ?>"
                                         class="d-block w-100" 
                                         style="height: 400px; object-fit: cover;"
                                         alt="<?php echo htmlspecialchars($item['title']); ?>">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5><?php echo htmlspecialchars($item['title']); ?></h5>
                                        <p><?php echo htmlspecialchars($item['description']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($carousel_items) > 1): ?>
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
                        <?php endif; ?>
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
</body>

</html>