<?php
$host = "localhost";
$user = "root";
$pass = "Jay@2005";
$db   = "cybercrime_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Use utf8
$conn->set_charset('utf8mb4');
?>
