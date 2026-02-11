<?php
// File: remove_car.php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = $_POST['car_id'] ?? null;
    if ($car_id) {
        $stmt = $pdo->prepare("DELETE FROM cars WHERE id = ?");
        $stmt->execute([$car_id]);
        $success = "Car removed successfully.";
    }
}

$cars = $pdo->query("SELECT * FROM cars")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Remove Car - Admin</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <img src="images/image.png" alt="Logo" class="logo">
    <h1>Remove Car</h1>
    <nav>
      <a href="admin.php">Admin Home</a>
      <a href="index.php">Logout</a>
    </nav>
  </header>

  <main>
    <section class="form-section">
      <h2>Available Cars</h2>
      <?php if (!empty($success)): ?>
        <p class="success-msg"><?php echo $success; ?></p>
      <?php endif; ?>
      <div class="car-grid">
        <?php foreach ($cars as $car): ?>
          <div class="car-card">
            <h3><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></h3>
            <p>Price: <?php echo $car['price_per_day']; ?> PLN</p>
            <form method="post">
              <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
              <button type="submit" class="danger">Remove</button>
            </form>
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
