<?php
// File: user.php
session_start();
require_once 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: user.php");
        exit();
    } else {
        $error = "Invalid credentials.";
    }
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}

$cars = $pdo->query("SELECT * FROM cars WHERE available = 1")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Panel - Rent a Car</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <img src="images/image.png" alt="Logo" class="logo">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <nav>
      <a href="rent_car.php">Rent Car</a>
      <a href="release_car.php">Release Car</a>
      <a href="index.php">Logout</a>
    </nav>
  </header>

  <main>
    <section class="car-list">
      <h2>Available Cars</h2>
      <div class="car-grid">
        <?php foreach ($cars as $car): ?>
          <div class="car-card">
            <h3><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></h3>
            <p>Price per day: <strong><?php echo $car['price_per_day']; ?> PLN</strong></p>
            <form method="post" action="rent_car.php">
              <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
              <button type="submit">Rent</button>
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
