<?php
include 'include/session-admin.php';
include 'include/config.php';

// Get carousel item for editing if ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $edit_query = mysqli_query($conn, "SELECT * FROM carousel WHERE id = '$id'");
    $result = mysqli_fetch_assoc($edit_query);
}

// Get all carousel items for the table
$query = mysqli_query($conn, "SELECT * FROM carousel");
$rows = mysqli_num_rows($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carousel | Shopping Cart</title>

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

        <h4>Admin - Manage Carousel</h4>
        <div class="row g-5">
            <div class="col-md-8 col-sm-12">
                <form action="<?php echo $base_url; ?>/carousel-form.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo isset($result['id']) ? $result['id'] : ''; ?>">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-12">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo isset($result['title']) ? $result['title'] : ''; ?>" required>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="1" <?php echo (isset($result['status']) && $result['status'] == 1) ? 'selected' : ''; ?>>Active</option>
                                <option value="0" <?php echo (isset($result['status']) && $result['status'] == 0) ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <?php if(!empty($result['image'])): ?>
                                <div>
                                    <img src="<?php echo $base_url; ?>/assets/images/carousel/<?php echo $result['image']; ?>" width="100" alt="Carousel Image">
                                </div>
                            <?php endif; ?>
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/png, image/jpg, image/jpeg" <?php echo empty($result['id']) ? 'required' : ''; ?>>
                        </div>

                        <div class="col-sm-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" required><?php echo isset($result['description']) ? htmlspecialchars($result['description']) : ''; ?></textarea>
                        </div>

                    </div>
                    <?php if(empty($result['id'])): ?>
                        <button class="btn btn-primary" type="submit"><i class="fa-regular fa-floppy-disk me-1"></i>Create</button>
                    <?php else: ?>
                        <button class="btn btn-primary" type="submit"><i class="fa-regular fa-floppy-disk me-1"></i>Update</button>
                    <?php endif; ?>

                    <a role="button" class="btn btn-secondary" href="<?php echo $base_url; ?>/carousel.php"><i class="fa-solid fa-rotate-left me-1"></i>Cancel</a>
                    <hr class="my-4">
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table id="orderTable" class="table table-bordered shadow-sm table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($rows > 0): ?>
                            <?php while ($carousel = mysqli_fetch_assoc($query)): ?>
                                <tr>
                                    <td><?php echo $carousel['id']; ?></td>
                                    <td>
                                        <img src="assets/images/carousel/<?php echo $carousel['image']; ?>" 
                                             alt="<?php echo $carousel['title']; ?>" 
                                             class="img-thumbnail" 
                                             style="height: 50px;">
                                    </td>
                                    <td><?php echo $carousel['title']; ?></td>
                                    <td>
                                        <?php if ($carousel['status'] == 1): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                    <a role="button" href="<?php echo $base_url; ?>/carousel.php?id=<?php echo $carousel['id']; ?>" class="btn btn-outline-dark"><i class="fa-regular fa-pen-to-square me-1"></i>Edit</a>
                                    <a onclick="return confirm('Are your sure you want to delete?');" role="button" href="<?php echo $base_url; ?>/carousel-delete.php?id=<?php echo $carousel['id']; ?>" class="btn btn-outline-danger"><i class="fa-solid fa-trash me-1"></i>Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No carousel items found</td>
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
    </script>
</body>

</html>