<?php
// File: rent_car.php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = $_POST['car_id'] ?? null;
    $user_id = $_SESSION['user_id'];

    if ($car_id) {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("UPDATE cars SET available = 0 WHERE id = ?");
        $stmt->execute([$car_id]);

        $stmt = $pdo->prepare("INSERT INTO rentals (user_id, car_id, is_active) VALUES (?, ?, 1)");
        $stmt->execute([$user_id, $car_id]);

        $pdo->commit();

        header("Location: user.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rent Car - User</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <img src="images/image.png" alt="Logo" class="logo">
    <h1>Rent Car</h1>
    <nav>
      <a href="user.php">User Home</a>
      <a href="index.php">Logout</a>
    </nav>
  </header>

  <main>
    <section class="form-section">
      <h2>Processing Rental...</h2>
      <p>If you see this, rental form was submitted without proper data.</p>
      <a href="user.php" class="btn">Go Back</a>
    </section>
  </main>

  <footer>
    <p>&copy; 2026 Specialty Class Rent a Car</p>
  </footer>
</body>
</html>
