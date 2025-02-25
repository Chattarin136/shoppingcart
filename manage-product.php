<?php
include 'include/session-admin.php';
include 'include/config.php';
include 'include/manage-product.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Product</title>

    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/solid.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
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

        <h4>Admin - Manage Product</h4>
        <div class="row g-5">
            <div class="col-md-8 col-sm-12">
                <form action="<?php echo $base_url; ?>/product-form.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control" onkeypress="return /[a-zA-Z\u0E00-\u0E7F\s]/.test(event.key)" value="<?php echo $result['product_name']; ?>" pattern="[a-zA-Z\u0E00-\u0E7F\s]+" title="Please enter Thai or English characters only" required>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Price</label>
                            <input type="number" min="0.00" max="100000.00" step="0.01" name="price" pattern="^\d+(\.\d{1,2})?$" class="form-control" value="<?php echo $result['price']; ?>" required>
                        </div>

                        <!-- Add this new category select field -->
                        <div class="col-sm-12">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-control" required>
                                <?php
                                $categories_sql = "SELECT * FROM categories WHERE name != 'all' ORDER BY display_name ASC";
                                $categories_query = mysqli_query($conn, $categories_sql);
                                while ($category = mysqli_fetch_assoc($categories_query)):
                                ?>
                                    <option value="<?php echo $category['name']; ?>" <?php echo (isset($result['category']) && $result['category'] == $category['name']) ? 'selected' : ''; ?>>
                                        <?php echo $category['display_name']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <?php if(!empty($result['profile_image'])): ?>
                                <div>
                                    <img src="<?php echo $base_url; ?>/upload_image/<?php echo $result['profile_image']; ?>" width="100" alt="Product Image">
                                </div>
                            <?php endif; ?>
                            <label for="formFile" class="form-label">Image</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/png, image/jpg, image/jpeg">                            
                        </div>

                        <div class="col-sm-12">
                            <label class="form-label">Detail</label>
                            <textarea name="detail" class="form-control" rows="3" onkeypress="return /[a-zA-Z\u0E00-\u0E7F\s]/.test(event.key)" required><?php echo htmlspecialchars($result['detail']); ?></textarea>
                        </div>

                    </div>
                    <?php if(empty($result['id'])): ?>
                        <button class="btn btn-primary" type="submit"><i class="fa-regular fa-floppy-disk me-1"></i>Create</button>
                    <?php else: ?>
                        <button class="btn btn-primary" type="submit"><i class="fa-regular fa-floppy-disk me-1"></i>Update</button>
                    <?php endif; ?>

                    <a role="button" class="btn btn-secondary" href="<?php echo $base_url; ?>/manage-product.php"><i class="fa-solid fa-rotate-left me-1"></i>Cancel</a>
                    <hr class="my-4">
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table id="productTable" class="table table-bordered shadow-sm table-striped">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th style="width: 200px;">Price</th>
                            <th style="width: 200px;" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($rows > 0): ?>
                            <?php while($product = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td>
                                    <?php if(!empty($product['profile_image'])): ?>
                                        <img src="<?php echo $base_url; ?>/upload_image/<?php echo $product['profile_image']; ?>" width="100" alt="Product Image">
                                    <?php else: ?>
                                        <img src="<?php echo $base_url; ?>/assets/images/no-image.png" width="100" alt="Product Image">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo $product['product_name']; ?>
                                    <div>
                                        <small class="text-muted"><?php echo nl2br($product['detail']); ?></small>
                                    </div>
                                </td>
                                <td><?php echo $product['category']; ?></td>
                                <td><?php echo number_format($product['price'], 2); ?></td>
                                <td>
                                    <a role="button" href="<?php echo $base_url; ?>/manage-product.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-dark"><i class="fa-regular fa-pen-to-square me-1"></i>Edit</a>
                                    <a onclick="return confirm('Are your sure you want to delete?');" role="button" href="<?php echo $base_url; ?>/product-delete.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-danger"><i class="fa-solid fa-trash me-1"></i>Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4"><h4 class="text-center text-danger">ไม่มีรายการสินค้า</h4></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
    <script src="<?php echo $base_url; ?>/assets/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#productTable').DataTable({
                responsive: true,
                order: [[1, 'asc']],
                pageLength: 10,
                columnDefs: [
                    { orderable: false, targets: [0, 3] },
                    // { searchable: false, targets: [0, 2, 3] }
                ]
            });
        });
    </script>
</body>
</html>