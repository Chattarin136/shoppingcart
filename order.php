<?php
include 'include/session-admin.php';
include 'include/config.php';
include 'include/order.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order | Shopping Cart</title>

    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/solid.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
</head>

<body class="bg-body-tertiary">
    <?php include 'include/menu.php'; ?>
    <div class="container">
        <?php if (!empty($_SESSION['message'])): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <div class="row mb-4">
            <!-- Best Sellers Chart -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar me-2"></i>Best Selling Products
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="bestSellersChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Orders Summary -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-shopping-cart me-2"></i>Orders Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <td>Total Orders:</td>
                                        <td class="text-end"><?php echo $rows; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Revenue:</td>
                                        <td class="text-end">฿<?php echo number_format($total_revenue, 2); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4>Order</h4>
        <div class="mb-4">
            <form method="post">
                <div class="d-flex justify-content-end">
                    <button type="submit" name="export" class="btn btn-success">Export to CSV</button>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-12">
                <table id="orderTable" class="table table-bordered shadow-sm table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Product</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Tel</th>
                            <th>Total</th>
                            <th>Address</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($rows > 0): ?>
                            <?php foreach ($orders_data as $product): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                                    <td><?php echo $product['product_details']; ?></td>
                                    <td><?php echo htmlspecialchars($product['fullname']); ?></td>
                                    <td><?php echo htmlspecialchars($product['email']); ?></td>
                                    <td><?php echo htmlspecialchars($product['tel']); ?></td>
                                    <td>฿<?php echo number_format($product['grand_total'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($product['address']); ?></td>
                                    <td class="text-center">
                                        <a href="order_detail.php?id=<?php echo htmlspecialchars($product['id']); ?>">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-danger">No orders found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="<?php echo $base_url; ?>/assets/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function () {
            $('#orderTable').DataTable({
                responsive: true,
                order: [[0, 'desc']],
                pageLength: 10,
                columnDefs: [
                    { orderable: false, targets: -1 }
                ]
            });
        });

        // Best Sellers Chart
        const ctx = $('#bestSellersChart')[0].getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Units Sold',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>

</html>