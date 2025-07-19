<?php
session_start();
require_once 'includes/db_connect.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);

    if ($user = $stmt->fetch()) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: user.php");
        }
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rent A Car</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
    body {
        background-color: #121212;
        color: #eee;
    }
    .login-box {
        background-color: #1e1e1e;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }
    form input, form button {
        background-color: #2c2c2c;
        color: #fff;
        border: 1px solid #444;
    }
    button:hover {
        background-color: #333;
    }
    </style>
</head>
<body>
<div class="logo" style="display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
    <img src="images/image.png" alt="Logo" style="width: 60px; height: auto; margin-right: 10px;">
    <h1 style="font-size: 24px; color: #fff;">Rent A Car</h1>
</div>
<div class="login-box">
    <h2>Login</h2>
    <?php if ($error): ?>
        <p style="color: red; text-align: center;"> <?= htmlspecialchars($error) ?> </p>
    <?php endif; ?>
    <form method="post" action="index.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>