<?php
// File: admin_users.php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require_once 'includes/db_connect.php';

// Delete user if requested
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
    header("Location: admin_users.php");
    exit();
}

$users = $pdo->query("SELECT id, name, email, address, role FROM users ORDER BY id ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - User List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>User Management</h2>
    <table border="1">
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Address</th><th>Role</th><th>Action</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['address']); ?></td>
                <td><?php echo $user['role']; ?></td>
                <td>
                    <?php if ($user['role'] !== 'admin'): ?>
                        <a href="?delete=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="admin.php">Back to Admin Panel</a>
</div>
</body>
</html>