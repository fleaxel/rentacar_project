<?php
// File: reset_token.php
require_once 'includes/db_connect.php';

$email = $_GET['email'] ?? '';
$token = $_GET['token'] ?? '';
$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND reset_token = ?");
    $stmt->execute([$email, $token]);

    if ($stmt->rowCount() === 1) {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE email = ?");
        $update->execute([$hashed, $email]);
        $success = "Password reset successful. <a href='index.php'>Login</a>";
    } else {
        $error = "Invalid or expired token.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Set New Password</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
  <h2>Set a New Password</h2>
  <?php if ($success): ?><p class="success"><?php echo $success; ?></p><?php endif; ?>
  <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
  <form method="post">
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
    <label>New Password:</label><br>
    <input type="password" name="new_password" required><br>
    <button type="submit">Reset Password</button>
  </form>
</div>
</body>
</html>