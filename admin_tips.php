<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) { header('Location: login.php'); exit(); }

// Handle add tip
if (isset($_POST['add'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $category = $conn->real_escape_string($_POST['category']);
    $content = $conn->real_escape_string($_POST['content']);
    $stmt = $conn->prepare('INSERT INTO tips (title,category,content,created_at) VALUES (?,?,?,NOW())');
    $stmt->bind_param('sss',$title,$category,$content);
    $stmt->execute();
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare('DELETE FROM tips WHERE id=?');
    $stmt->bind_param('i',$id);
    $stmt->execute();
}

$tips = $conn->query('SELECT * FROM tips ORDER BY created_at DESC');
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Admin - Tips</title><link rel="stylesheet" href="style.css"></head>
<body>
    <nav class="nav"><div class="brand">CyberSafe (Admin)</div><div><a href="index.php">Home</a> <a href="logout.php">Logout</a></div></nav>
    <main class="container">
        <h2>Manage Tips</h2>
        <div class="card form-card">
            <h3>Add Tip</h3>
            <form method="post">
                <input name="title" placeholder="Title" required>
                <input name="category" placeholder="Category e.g. Phishing" required>
                <textarea name="content" rows="6" placeholder="Tip content..." required></textarea>
                <button name="add" class="btn">Add Tip</button>
            </form>
        </div>

        <h3>Existing Tips</h3>
        <table>
            <tr><th>ID</th><th>Title</th><th>Category</th><th>Date</th><th>Action</th></tr>
            <?php while($t=$tips->fetch_assoc()): ?>
            <tr>
                <td><?= $t['id']; ?></td>
                <td><?= htmlspecialchars($t['title']); ?></td>
                <td><?= htmlspecialchars($t['category']); ?></td>
                <td><?= $t['created_at']; ?></td>
                <td><a href="?delete=<?= $t['id']; ?>" onclick="return confirm('Delete?')">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </main>
</body>
</html>
