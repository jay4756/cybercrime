<?php
include 'config.php';
session_start();
if (isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare('SELECT id,name,email,password,is_admin FROM users WHERE email=? LIMIT 1');
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $user = $res->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['is_admin'] = (int)$user['is_admin'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Invalid credentials';
        }
    } else {
        $error = 'User not found';
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Login - CyberSafe</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="card form-card">
        <h2>Login</h2>
        <?php if(isset($error)) echo '<p class="error">'.htmlspecialchars($error).'</p>'; ?>
        <form method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="btn">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
