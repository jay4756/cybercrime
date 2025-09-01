<?php
session_start();
include 'config.php';

// Fetch all tips
$tips = $conn->query("SELECT * FROM tips ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cyber Fraud Awareness</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="nav">
        <div class="brand">CyberSafe</div>
        <div>
            <?php if(isset($_SESSION['user'])): ?>
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
            <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                <a href="admin_tips.php">Admin</a>
            <?php endif; ?>
        </div>
    </nav>

    <header class="hero">
        <h1>Protect Yourself from Cyber Fraud</h1>
        <p>Learn common scams and what to do if you become a victim.</p>
        <a class="btn" href="#tips">See Tips</a>
    </header>

    <main class="container">
        <section id="tips">
            <h2>Latest Tips</h2>
            <div class="grid">
                <?php while($tip = $tips->fetch_assoc()): ?>
                <article class="card">
                    <h3><?= htmlspecialchars($tip['title']); ?></h3>
                    <p><?= nl2br(htmlspecialchars(substr($tip['content'],0,300))); ?>...</p>
                    <p class="meta">Category: <?= htmlspecialchars($tip['category']); ?></p>
                    <a class="small" href="view_tip.php?id=<?= $tip['id']; ?>">Read more</a>
                </article>
                <?php endwhile; ?>
            </div>
        </section>

        <section>
            <h2>What to do if you're targeted</h2>
            <ul class="advice">
                <li>Don't share OTPs, passwords, or bank details with anyone.</li>
                <li>Verify requests by contacting the official organization through known channels.</li>
                <li>Report suspicious messages or calls to your bank and local authorities.</li>
                <li>Change passwords immediately and enable 2FA where possible.</li>
                <li>Keep screenshots and transaction details for evidence.</li>
            </ul>
        </section>

        <section>
            <h2>Need Help? Report an Incident</h2>
            <p><a class="btn" href="report.php">Report Now</a></p>
        </section>
    </main>

    <footer class="footer">
        <p>© <?= date('Y'); ?> CyberSafe — Stay alert, stay safe online.</p>
    </footer>
</body>
</html>
