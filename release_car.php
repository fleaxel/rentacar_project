<?php
// File: release_car.php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = $_POST['car_id'] ?? null;

    if ($car_id) {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("UPDATE cars SET available = 1 WHERE id = ?");
        $stmt->execute([$car_id]);

        $stmt = $pdo->prepare("UPDATE rentals SET is_active = 0 WHERE user_id = ? AND car_id = ? AND is_active = 1");
        $stmt->execute([$user_id, $car_id]);

        $pdo->commit();

        header("Location: user.php");
        exit();
    }
}

$stmt = $pdo->prepare("SELECT cars.* FROM cars 
                       JOIN rentals ON cars.id = rentals.car_id 
                       WHERE rentals.user_id = ? AND rentals.is_active = 1");
$stmt->execute([$user_id]);
$rentedCars = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Release Car - User</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <img src="images/image.png" alt="Logo" class="logo">
    <h1>Release Car</h1>
    <nav>
      <a href="user.php">User Home</a>
      <a href="index.php">Logout</a>
    </nav>
  </header>

  <main>
    <section class="form-section">
      <h2>Cars You've Rented</h2>
      <?php if (empty($rentedCars)): ?>
        <p>You currently have no active rentals.</p>
      <?php else: ?>
        <div class="car-grid">
          <?php foreach ($rentedCars as $car): ?>
            <div class="car-card">
              <h3><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></h3>
              <p>Price per day: <?php echo $car['price_per_day']; ?> PLN</p>
              <form method="post">
                <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
                <button type="submit" class="danger">Release</button>
              </form>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>
  </main>

  <footer>
    <p>&copy; 2026 Specialty Class Rent a Car</p>
  </footer>
</body>
</html>
