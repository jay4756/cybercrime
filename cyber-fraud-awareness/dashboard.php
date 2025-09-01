<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user'])) { header('Location: login.php'); exit(); }

// Fetch user's reports
$email = $conn->real_escape_string($_SESSION['user']);
$reports = $conn->query("SELECT * FROM reports WHERE reporter_email='$email' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Dashboard - CyberSafe</title><link rel="stylesheet" href="style.css"></head>
<body>
    <nav class="nav">
        <div class="brand">CyberSafe</div>
        <div>
            <a href="index.php">Home</a>
            <a href="report.php">Report</a>
            <a href="logout.php">Logout</a>
            <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                <a href="admin_tips.php">Admin</a>
            <?php endif; ?>
        </div>
    </nav>

    <main class="container">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['name']); ?></h2>
        <section>
            <h3>Your Reports</h3>
            <?php if ($reports && $reports->num_rows>0): ?>
                <table>
                    <tr><th>ID</th><th>Type</th><th>Details</th><th>Status</th><th>Date</th></tr>
                    <?php while($r=$reports->fetch_assoc()): ?>
                    <tr>
                        <td><?= $r['id']; ?></td>
                        <td><?= htmlspecialchars($r['type']); ?></td>
                        <td><?= htmlspecialchars(substr($r['details'],0,80)); ?>...</td>
                        <td><?= htmlspecialchars($r['status']); ?></td>
                        <td><?= $r['created_at']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No reports yet. <a href="report.php">Report an incident</a></p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
