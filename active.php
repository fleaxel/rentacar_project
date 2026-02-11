<?php
// File: activate.php
require_once 'includes/db_connect.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE token = ? AND active = 0");
    $stmt->execute([$token]);

    if ($stmt->rowCount() > 0) {
        $stmt = $pdo->prepare("UPDATE users SET active = 1, token = NULL WHERE token = ?");
        $stmt->execute([$token]);

        echo "<h2>Your account has been activated. You can now <a href='index.php'>login</a>.</h2>";
    } else {
        echo "<h2>Invalid or already used activation token.</h2>";
    }
} else {
    echo "<h2>No activation token provided.</h2>";
}
?>