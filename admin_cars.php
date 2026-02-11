<?php
// File: admin_cars.php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: index.php");
  exit();
}

$cars = $pdo->query("SELECT * FROM cars ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Cars - Admin</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <img src="images/image.png" alt="Logo" class="logo">
    <h1>Manage Cars</h1>
    <nav>
      <a href="admin.php">Admin Home</a>
      <a href="index.php">Logout</a>
    </nav>
  </header>

  <main>
    <section>
      <h2>All Cars</h2>
      <div class="car-grid">
        <?php foreach ($cars as $car): ?>
          <div class="car-card">
            <h3><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></h3>
            <p>Price per Day: <?php echo $car['price_per_day']; ?> PLN</p>
            <p>Status: <?php echo $car['available'] ? 'Available' : 'Rented'; ?></p>
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
