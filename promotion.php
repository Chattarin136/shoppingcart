<?php
include 'include/session-admin.php';
include 'include/config.php';

// Fetch all promotions
$query = mysqli_query($conn, "SELECT * FROM promocodes ORDER BY id DESC");
$rows = mysqli_num_rows($query);

// Fetch single promotion for editing
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM promocodes WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Promotions</title>

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
        <div class="alert alert-<?php echo isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'warning'; ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php 
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        endif; 
        ?>

        <h4>Admin - Manage Promotions</h4>
        <div class="row g-5">
            <div class="col-md-8 col-sm-12">
                <form action="<?php echo $base_url; ?>/promotion-form.php" method="post">
                    <!-- <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> -->
                    <input type="hidden" name="id" value="<?php echo isset($result['id']) ? htmlspecialchars($result['id']) : ''; ?>">
                    
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Promotion Code</label>
                            <input type="text" 
                                   name="code" 
                                   class="form-control" 
                                   value="<?php echo isset($result['code']) ? htmlspecialchars($result['code']) : ''; ?>" 
                                   pattern="[A-Za-z0-9]{4,16}"
                                   title="Code must be 4-16 characters long and contain only letters and numbers"
                                   required>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Discount Value</label>
                            <div class="input-group">
                                <span class="input-group-text">฿</span>
                                <input type="number" 
                                       name="discount_value" 
                                       class="form-control" 
                                       value="<?php echo isset($result['discount_value']) ? htmlspecialchars($result['discount_value']) : ''; ?>"
                                       min="0"
                                       max="5000"
                                       step="1"
                                       required>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <label class="form-label">Promotion Text</label>
                            <textarea name="promotion_text" 
                                      class="form-control" 
                                      rows="3" 
                                      required><?php echo isset($result['promotion_text']) ? htmlspecialchars($result['promotion_text']) : ''; ?></textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <?php if(empty($result['id'])): ?>
                            <button class="btn btn-primary" type="submit">
                                <i class="fa-regular fa-plus me-1"></i>Create Promotion
                            </button>
                        <?php else: ?>
                            <button class="btn btn-primary" type="submit">
                                <i class="fa-regular fa-floppy-disk me-1"></i>Update Promotion
                            </button>
                        <?php endif; ?>

                        <a role="button" class="btn btn-secondary" href="<?php echo $base_url; ?>/promotion.php">
                            <i class="fa-solid fa-rotate-left me-1"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
            <div class="card-body">
                        <table id="promotionTable" class="table table-bordered shadow-sm table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Code</th>
                                    <th>Promotion Text</th>
                                    <th>Discount</th>
                                    <th>Status</th>
                                    <th style="width: 200px;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($rows > 0): ?>
                                    <?php while($data = mysqli_fetch_assoc($query)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($data['id']); ?></td>
                                        <td><?php echo htmlspecialchars($data['code']); ?></td>
                                        <td><?php echo htmlspecialchars($data['promotion_text']); ?></td>
                                        <td>฿<?php echo number_format(htmlspecialchars($data['discount_value']), 2); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $data['status'] ? 'success' : 'danger'; ?>">
                                                <?php echo $data['status'] ? 'Active' : 'Inactive'; ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?php echo $base_url; ?>/promotion.php?id=<?php echo $data['id']; ?>" 
                                               class="btn btn-outline-dark">
                                                <i class="fa-regular fa-pen-to-square me-1"></i>Edit
                                            </a>
                                            
                                            <button type="button" 
                                                    class="btn btn-outline-danger delete-promotion" 
                                                    data-id="<?php echo $data['id']; ?>"
                                                    data-code="<?php echo htmlspecialchars($data['code']); ?>">
                                                <i class="fa-regular fa-trash-can me-1"></i>Delete
                                                
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
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
        const baseUrl = '<?php echo $base_url; ?>';
        $(document).ready(function() {
            $('#promotionTable').DataTable({
                responsive: true,
                order: [[0, 'desc']],
                pageLength: 10,
                columnDefs: [
                    { orderable: false, targets: -1 }
                ]
            });

            $('.delete-promotion').click(function() {
                const id = $(this).data('id');
                const code = $(this).data('code');
                if (confirm(`Are you sure you want to delete promotion code "${code}"?`)) {
                    window.location.href = `${baseUrl}/promotion-delete.php?id=${id}`;
                }
            });
        });
    </script>
</body>
</html>