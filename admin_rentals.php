<?php
// File: admin_rentals.php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: index.php");
  exit();
}

$stmt = $pdo->query("SELECT r.id, r.is_active, u.username, c.brand, c.model, r.created_at
                      FROM rentals r
                      JOIN users u ON r.user_id = u.id
                      JOIN cars c ON r.car_id = c.id
                      ORDER BY r.created_at DESC");
$rentals = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rental Records - Admin</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <img src="images/image.png" alt="Logo" class="logo">
    <h1>Rental Records</h1>
    <nav>
      <a href="admin.php">Admin Home</a>
      <a href="index.php">Logout</a>
    </nav>
  </header>

  <main>
    <section>
      <h2>All Rental Transactions</h2>
      <div class="car-grid">
        <?php foreach ($rentals as $rental): ?>
          <div class="car-card">
            <h3><?php echo htmlspecialchars($rental['brand'] . ' ' . $rental['model']); ?></h3>
            <p>User: <?php echo htmlspecialchars($rental['username']); ?></p>
            <p>Date: <?php echo $rental['created_at']; ?></p>
            <p>Status: <?php echo $rental['is_active'] ? 'Active' : 'Returned'; ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2026 Specialty Class Rent a Car</p>
  </footer>
</body>
</html>
