<?php
include 'include/session-admin.php';
include 'include/config.php';

$query = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
$rows = mysqli_num_rows($query);
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
                <form action="<?php echo $base_url; ?>/user-form.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Point</label>
                            <input type="number" min="0" max="5000" step="1" name="point" class="form-control" value="<?php echo isset($result['point']) ? (int)$result['point'] : 0; ?>" required>
                        </div>
                    </div>
                    <?php if(!empty($result['id'])): ?>
                        <button class="btn btn-primary" type="submit"><i class="fa-regular fa-floppy-disk me-1"></i>Update</button>
                    <?php endif; ?>

                    <a role="button" class="btn btn-secondary" href="<?php echo $base_url; ?>/user.php"><i class="fa-solid fa-rotate-left me-1"></i>Cancel</a>
                    <hr class="my-4">
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table id="productTable" class="table table-bordered shadow-sm table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>username</th>
                            <th>name</th>
                            <th>tel</th>
                            <th>email</th>
                            <th>points</th>
                            <th>status</th>
                            <th>address</th>
                            <th style="width: 100px;" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($rows > 0): ?>
                            <?php while($data = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td>
                                    <?php echo $data['Id']; ?>
                                </td>
                                <td>
                                    <?php echo $data['username']; ?>
                                </td>
                                <td><?php echo $data['name']. ' ' .$data['surname'] ?></td>
                                <td><?php echo $data['tel']; ?></td>
                                <td><?php echo $data['email']; ?></td>
                                <td><?php echo $data['points']; ?></td>
                                <td>
                                        <?php if ($data['status'] == 1): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                <td><?php echo $data['address']; ?></td>
                                <td>
                                <a role="button" href="<?php echo $base_url; ?>/user.php?id=<?php echo $data['Id']; ?>" class="btn btn-outline-dark"><i class="fa-regular fa-pen-to-square me-1"></i>Edit</a>
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
                    { orderable: false, targets: -1 }
                ]
            });
        });
    </script>
</body>
</html>