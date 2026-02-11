<?php
// File: change_password.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'includes/db_connect.php';

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if (password_verify($current_password, $user['password'])) {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update->execute([$hashed, $_SESSION['user_id']]);
        $success = "Password changed successfully.";
    } else {
        $error = "Current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>
        <?php if ($success): ?><p class="success"><?php echo $success; ?></p><?php endif; ?>
        <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
        <form method="post">
            <label>Current Password:</label><br>
            <input type="password" name="current_password" required><br>
            <label>New Password:</label><br>
            <input type="password" name="new_password" required><br>
            <button type="submit">Change Password</button>
        </form>
        <a href="profile.php">Back to Profile</a>
    </div>
</body>
</html>