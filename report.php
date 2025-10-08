<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user'])) { header('Location: login.php'); exit(); }

if (isset($_POST['submit'])) {
    $type = $conn->real_escape_string($_POST['type']);
    $details = $conn->real_escape_string($_POST['details']);
    $email = $conn->real_escape_string($_SESSION['user']);

    $stmt = $conn->prepare('INSERT INTO reports (reporter_email,type,details,status,created_at) VALUES (?,?,?,?,NOW())');
    $status = 'Received';
    $stmt->bind_param('ssss',$email,$type,$details,$status);
    if ($stmt->execute()) {
        $success = 'Report submitted. Authorities may contact you.';
    } else {
        $error = 'Failed to submit report.';
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Report - CyberSafe</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="card form-card">
        <h2>Report an Incident</h2>
        <?php if(isset($error)) echo '<p class="error">'.htmlspecialchars($error).'</p>'; ?>
        <?php if(isset($success)) echo '<p class="success">'.htmlspecialchars($success).'</p>'; ?>
        <form method="post">
            <label>Type</label>
            <select name="type" required>
                <option>Phishing</option>
                <option>Online Shopping Fraud</option>
                <option>Banking Fraud</option>
                <option>Social Media Scam</option>
                <option>Other</option>
            </select>
            <label>Details</label>
            <textarea name="details" rows="6" placeholder="Describe what happened..." required></textarea>
            <button type="submit" name="submit" class="btn">Submit Report</button>
        </form>
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>
