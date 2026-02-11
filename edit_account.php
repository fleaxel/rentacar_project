<?php
// File: edit_account.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'includes/db_connect.php';

$success = $error = '';

$stmt = $pdo->prepare("SELECT name, email, address FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);

    $update = $pdo->prepare("UPDATE users SET name = ?, email = ?, address = ? WHERE id = ?");
    if ($update->execute([$name, $email, $address, $_SESSION['user_id']])) {
        $success = "Account details updated successfully.";
    } else {
        $error = "Failed to update account details.";
    }

    // Reload updated data
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Account</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Account Details</h2>
        <?php if ($success): ?><p class="success"><?php echo $success; ?></p><?php endif; ?>
        <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
        <form method="post">
            <label>Name:</label><br>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>
            <label>Email:</label><br>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
            <label>Address:</label><br>
            <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required><br>
            <button type="submit">Update</button>
        </form>
        <a href="profile.php">Back to Profile</a>
    </div>
</body>
</html>