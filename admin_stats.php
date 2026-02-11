<?php
// File: admin_stats.php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require_once 'includes/db_connect.php';

// Most rented cars
$car_stats = $pdo->query("SELECT car_model, COUNT(*) AS rent_count FROM rentals GROUP BY car_model ORDER BY rent_count DESC LIMIT 10")->fetchAll();

// Most active users
$user_stats = $pdo->query("SELECT users.name, users.email, COUNT(*) AS rental_count FROM rentals JOIN users ON rentals.user_id = users.id GROUP BY users.id ORDER BY rental_count DESC LIMIT 10")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Stats</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Rental Statistics</h2>

    <h3>Top 10 Most Rented Cars</h3>
    <table border="1">
        <tr><th>Car Model</th><th>Times Rented</th></tr>
        <?php foreach ($car_stats as $car): ?>
            <tr>
                <td><?php echo htmlspecialchars($car['car_model']); ?></td>
                <td><?php echo $car['rent_count']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Top 10 Most Active Users</h3>
    <table border="1">
        <tr><th>Name</th><th>Email</th><th>Rentals</th></tr>
        <?php foreach ($user_stats as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo $user['rental_count']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="admin.php">Back to Admin Panel</a>
</div>
</body>
</html>