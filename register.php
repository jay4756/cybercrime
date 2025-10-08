<?php
include 'config.php';
session_start();
if (isset($_POST['register'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $conn->real_escape_string($_POST['name']);

    $stmt = $conn->prepare('INSERT INTO users (name,email,password,is_admin) VALUES (?,?,?,0)');
    $stmt->bind_param('sss',$name,$email,$password);
    if ($stmt->execute()) {
        $_SESSION['user'] = $email;
        $_SESSION['name'] = $name;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Registration failed: ' . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Register - CyberSafe</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="card form-card">
        <h2>Create account</h2>
        <?php if(isset($error)) echo '<p class="error">'.htmlspecialchars($error).'</p>'; ?>
        <form method="post">
            <input name="name" placeholder="Full name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register" class="btn">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
