<!-- generate_hast_password.php -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    if ($password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        echo "hash password: " . $hashed;
    }
}
?>
<form method="post">
    <br />
    <input type="text" name="password" placeholder="Enter password">
    <button type="submit">Generate Hash</button>
</form>