<?php
// File: admin_cars.php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require_once 'includes/db_connect.php';

$cars = $pdo->query("SELECT * FROM cars ORDER BY id DESC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = (int) $_POST['delete_id'];
    $pdo->prepare("DELETE FROM cars WHERE id = ?")->execute([$id]);
    header("Location: admin_cars.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Cars - Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Manage Cars</h2>
    <table border="1">
        <tr><th>ID</th><th>Model</th><th>Brand</th><th>Price/Day</th><th>Status</th><th>Action</th></tr>
        <?php foreach ($cars as $car): ?>
            <tr>
                <td><?php echo $car['id']; ?></td>
                <td><?php echo htmlspecialchars($car['model']); ?></td>
                <td><?php echo htmlspecialchars($car['brand']); ?></td>
                <td><?php echo $car['price_per_day']; ?> PLN</td>
                <td><?php echo $car['available'] ? 'Available' : 'Rented'; ?></td>
                <td>
                    <form method="post" style="display:inline">
                        <input type="hidden" name="delete_id" value="<?php echo $car['id']; ?>">
                        <button type="submit" onclick="return confirm('Delete this car?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="admin.php">Back to Admin Panel</a>
</div>
</body>
</html>