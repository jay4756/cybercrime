<?php
include 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $conn->prepare('SELECT * FROM tips WHERE id=?');
$stmt->bind_param('i',$id);
$stmt->execute();
$res = $stmt->get_result();
if (!$res || $res->num_rows==0) { header('Location: index.php'); exit(); }
$tip = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title><?= htmlspecialchars($tip['title']); ?> - CyberSafe</title><link rel="stylesheet" href="style.css"></head>
<body>
    <nav class="nav"><div class="brand">CyberSafe</div><div><a href="index.php">Home</a></div></nav>
    <main class="container">
        <article class="card">
            <h2><?= htmlspecialchars($tip['title']); ?></h2>
            <p class="meta">Category: <?= htmlspecialchars($tip['category']); ?> | Posted: <?= $tip['created_at']; ?></p>
            <div><?= nl2br(htmlspecialchars($tip['content'])); ?></div>
            <p><a href="index.php">Back</a></p>
        </article>
    </main>
</body>
</html>
