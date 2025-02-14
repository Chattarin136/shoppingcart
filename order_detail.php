<?php
include 'include/session-admin.php';
include 'include/config.php';

$sql = "SELECT od.order_id, od.product_id, p.profile_image, p.detail, od.product_name, od.price, 
    od.quantity, od.total FROM order_details od 
    JOIN products p ON p.id=od.product_id 
    WHERE od.order_id = " . $_GET['id'];
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'include/menu.php'; ?>
    <div class="container mt-4">
        <h4>Order</h4>
        <div class="d-flex justify-content-end m-3">
            <a href="/shoppingcart/order.php"><button type="button" class="btn btn-danger">Back</button></a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered border-info">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $order_no = 0;
                    while($row = mysqli_fetch_assoc($result)) { 
                        $order_no++; 
                    ?>
                    <tr>
                        <td><?php echo $order_no; ?></td>
                        <td>
                            <img src="<?php echo $base_url . '/upload_image/' . $row['profile_image']; ?>" alt="<?php echo $row['product_name']; ?>" class="img-thumbnail" style="width: 100px;">
                        </td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td>฿<?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>฿<?php echo number_format($row['total'], 2); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>