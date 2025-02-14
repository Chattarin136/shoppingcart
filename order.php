<?php
include 'include/session-admin.php';
include 'include/config.php';

$query = mysqli_query($conn, "SELECT 
    o.id,
    o.fullname,
    o.email,
    o.tel,
    o.address,
    o.grand_total,
    (SELECT GROUP_CONCAT(CONCAT(p.product_name, ' (', od2.quantity, ')') SEPARATOR '<br/> ')  
     FROM order_details od2 
     JOIN products p ON od2.product_id = p.id 
     WHERE od2.order_id = o.id) as product_details
FROM orders o
GROUP BY o.id, o.fullname, o.email, o.tel, o.address, o.grand_total");
$rows = mysqli_num_rows($query);
$DATE_TIME = date('YmdHis');

if(isset($_POST['export'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="Orders_' . $DATE_TIME . '.csv"');

    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    fputcsv($output, array('Id', 'Full Name', 'Email', 'Tel', 'Products', 'Total', 'Address'));
    
    $query = mysqli_query($conn, "SELECT 
    o.id,
    o.fullname,
    o.email,
    o.tel,
    o.address,
    o.grand_total,
    (SELECT GROUP_CONCAT(CONCAT(p.product_name, ' (', od2.quantity, ')') SEPARATOR ', ')  
     FROM order_details od2 
     JOIN products p ON od2.product_id = p.id 
     WHERE od2.order_id = o.id) as product_details
FROM orders o
GROUP BY o.id, o.fullname, o.email, o.tel, o.address, o.grand_total");
    
    while($data = mysqli_fetch_array($query)) {
        fputcsv($output, array(
            $data['id'],
            $data['fullname'],
            $data['email'],
            sprintf("%s-%s-%s", 
                substr($data['tel'], 0, 3),
                substr($data['tel'], 3, 3),
                substr($data['tel'], 6)
            ),
            $data['product_details'],
            number_format($data['grand_total'], 2),
            $data['address']
        ));
    }
    
    fclose($output);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/solid.min.css" rel="stylesheet">
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

        <h4>Order</h4>
        <form method="post" style="margin: 20px;">
            <div class="d-flex justify-content-end">
                <button type="submit" name="export" class="btn btn-success">Export to CSV</button>
            </div>
        </form>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered border-info">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Id</th>
                            <th style="width: 150px;">Product</th>
                            <th>Full Name</th>
                            <th style="width: 200px;">Email</th>
                            <th style="width: 200px;">Tel</th>
                            <th style="width: 100px;">Total</th>
                            <th style="width: 200px;">Address</th>
                            <th style="width: 100px;">
                            <div class="d-flex justify-content-center">Action</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($rows > 0): ?>
                            <?php while($product = mysqli_fetch_assoc($query)): ?>
                            <tr></tr>
                                <td><?php echo $product['id']; ?></td>
                                <td><?php echo $product['product_details']; ?></td>
                                <td><?php echo $product['fullname']; ?></td>
                                <td><?php echo $product['email']; ?></td>
                                <td><?php echo $product['tel']; ?></td>
                                <td>฿<?php echo number_format($product['grand_total'], 2); ?></td>
                                <td><?php echo $product['address']; ?></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="order_detail.php?id=<?php echo $product['id']; ?>">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            <tr>

                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="6"><h4 class="text-center text-danger">ไม่มีรายการคำสั่งซื้อสินค้า</h4></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script src="<?php echo $base_url; ?>/assets/js/bootstrap.min.js"></script>
</body>
</html>