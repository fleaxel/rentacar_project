<?php
// File: reset_password.php
require_once 'includes/db_connect.php';

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() === 1) {
        $token = bin2hex(random_bytes(16));
        $update = $pdo->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
        $update->execute([$token, $email]);

        $link = "http://localhost/rentacar_project-main/reset_token.php?email=" . urlencode($email) . "&token=$token";
        $success = "Reset link: <a href='$link'>$link</a>";
    } else {
        $error = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
  <h2>Reset Password</h2>
  <?php if ($success): ?><p class="success"><?php echo $success; ?></p><?php endif; ?>
  <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
  <form method="post">
    <label>Email:</label><br>
    <input type="email" name="email" required><br>
    <button type="submit">Send Reset Link</button>
  </form>
  <a href="index.php">Back to Login</a>
</div>
</body>
</html>