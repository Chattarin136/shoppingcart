<?php
include 'include/session-admin.php';
include 'include/config.php';
include 'include/order_detail.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>

    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/solid.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
</head>

<body class="bg-light">
    <?php include 'include/menu.php'; ?>
    <div class="container mt-4">
        <h4>Order Details</h4>
        <div class="mb-4">
        </div>
        <table id="orderDetailTable" class="table table-bordered shadow-sm table-striped">
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
                while ($row = mysqli_fetch_assoc($result)) {
                    $order_no++;
                    ?>
                    <tr>
                        <td><?php echo $order_no; ?></td>
                        <td>
                            <img src="<?php echo $base_url . '/upload_image/' . $row['profile_image']; ?>"
                                alt="<?php echo $row['product_name']; ?>" class="img-thumbnail" style="width: 100px;">
                        </td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td>฿<?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>฿<?php echo number_format($row['total'], 2); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="text-end mt-4">
            <a href="order.php" class="text-decoration-none">
                <i class="bi bi-arrow-left me-2"></i>Back to Order
            </a>
        </div>
    </div>


    <script src="<?php echo $base_url; ?>/assets/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#orderDetailTable').DataTable({
                responsive: true,
                order: [[0, 'asc']],
                pageLength: 10,
                columnDefs: [
                    { orderable: false, targets: 1 }
                ]
            });
        });
    </script>
</body>

</html>