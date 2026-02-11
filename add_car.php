<?php
// File: add_car.php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand = $_POST['brand'] ?? '';
    $model = $_POST['model'] ?? '';
    $price = $_POST['price'] ?? 0;

    $stmt = $pdo->prepare("INSERT INTO cars (brand, model, price_per_day, available) VALUES (?, ?, ?, 1)");
    $stmt->execute([$brand, $model, $price]);

    $success = "Car added successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Car - Admin</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <img src="images/image.png" alt="Logo" class="logo">
    <h1>Add New Car</h1>
    <nav>
      <a href="admin.php">Admin Home</a>
      <a href="index.php">Logout</a>
    </nav>
  </header>

  <main>
    <section class="form-section">
      <h2>Enter Car Details</h2>
      <?php if (!empty($success)): ?>
        <p class="success-msg"><?php echo $success; ?></p>
      <?php endif; ?>
      <form method="post">
        <label for="brand">Brand:</label>
        <input type="text" name="brand" required>

        <label for="model">Model:</label>
        <input type="text" name="model" required>

        <label for="price">Price per Day (PLN):</label>
        <input type="number" name="price" min="0" required>

        <button type="submit">Add Car</button>
      </form>
    </section>
  </main>

  <footer>
    <p>&copy; 2026 Specialty Class Rent a Car</p>
  </footer>
</body>
</html>
