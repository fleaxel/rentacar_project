<?php
// File: delete_account.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);

    session_unset();
    session_destroy();
    header("Location: index.php?message=account_deleted");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Account</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Delete Account</h2>
        <p>Are you sure you want to delete your account? This action cannot be undone.</p>
        <form method="post">
            <button type="submit">Yes, Delete My Account</button>
        </form>
        <a href="profile.php">Cancel</a>
    </div>
</body>
</html>