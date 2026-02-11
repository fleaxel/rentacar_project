<?php
// File: admin_rentals.php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require_once 'includes/db_connect.php';

$rentals = $pdo->query("SELECT rentals.id, users.name AS user_name, cars.model AS car_model, rentals.rent_date, rentals.return_date FROM rentals JOIN users ON rentals.user_id = users.id JOIN cars ON rentals.car_id = cars.id ORDER BY rentals.rent_date DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Rental Records</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Rental History</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Car</th>
            <th>Rent Date</th>
            <th>Return Date</th>
        </tr>
        <?php foreach ($rentals as $rental): ?>
            <tr>
                <td><?php echo $rental['id']; ?></td>
                <td><?php echo htmlspecialchars($rental['user_name']); ?></td>
                <td><?php echo htmlspecialchars($rental['car_model']); ?></td>
                <td><?php echo $rental['rent_date']; ?></td>
                <td><?php echo $rental['return_date'] ?? 'Not returned'; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="admin.php">Back to Admin Panel</a>
</div>
</body>
</html>