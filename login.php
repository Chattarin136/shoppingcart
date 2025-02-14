<?php
session_start();
include 'include/config.php';

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    
    $sql = "SELECT u.Id user_id, u.username, u.`password`, u.`name`, u.surname, 
        u.tel, u.email, u.address, u.`status`, p.id, p.user_id, p.role 
        FROM users u LEFT JOIN permission_users p ON p.user_id = u.Id 
        WHERE u.username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            session_regenerate_id(true);
            $_SESSION['id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['surname'] = $row['surname'];
            $_SESSION['tel'] = $row['tel'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['address'] = $row['address'];
            $_SESSION['role'] = $row['role'];
            
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-body-tertiary">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Login</h3>
                </div>
                <div class="card-body">
                    <?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <div class="d-grid gap-2 mt-2">
                            <a href="/shoppingcart/register.php" class="btn btn-secondary w-100">Register</a>
                            <a href="forgot-password.php">Forgot Password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>