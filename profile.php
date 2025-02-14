<?php
include 'include/session.php';
include 'include/config.php';

// Check if form is submitted
if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $name = $_POST['name']; 
    $surname = $_POST['surname'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $user_id = $_SESSION['id'];

    $sql = "UPDATE users SET 
            username = ?, 
            name = ?, 
            surname = ?, 
            tel = ?, 
            email = ?, 
            address = ? 
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $username, $name, $surname, $tel, $email, $address, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Profile updated successfully";
    } else {
        $_SESSION['error'] = "Something went wrong";
    }
}

// Get current user data
$user_id = $_SESSION['id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE Id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/solid.min.css" rel="stylesheet">
</head>
<body class="bg-body-tertiary">
    <?php include 'include/menu.php'; ?>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Update Profile</h2>
                        <?php if (isset($_SESSION['success'])) { ?>
                            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
                        <?php } ?>
                        <?php if (isset($_SESSION['error'])) { ?>
                            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                        <?php } ?>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Surname</label>
                                <input type="text" class="form-control" name="surname" value="<?php echo htmlspecialchars($row['surname']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tel</label>
                                <input type="text" class="form-control" name="tel" pattern="^0[689]\d{8}$" value="<?php echo htmlspecialchars($row['tel']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" required><?php echo htmlspecialchars($row['address']); ?></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="update" class="btn btn-primary">Update Profile</button>
                                <a href="index.php" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo $base_url; ?>/assets/js/bootstrap.min.js"></script>
</body>
</html>