<?php
// File: admin.php
session_start();
require_once 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user && $user['role'] === 'admin') {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: admin.php");
        exit();
    } else {
        $error = "Invalid credentials or not an admin.";
    }
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Rent a Car</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <img src="images/image.png" alt="Logo" class="logo">
    <h1>Admin Panel - Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <nav>
      <a href="add_car.php">Add Car</a>
      <a href="remove_car.php">Remove Car</a>
      <a href="release_car.php">Release Car</a>
      <a href="admin_cars.php">Manage Cars</a>
      <a href="admin_rentals.php">Rental Records</a>
      <a href="index.php">Logout</a>
    </nav>
  </header>

  <main>
    <section class="admin-section">
      <h2>Admin Tools</h2>
      <p>Use the navigation above to manage the system: cars, rentals, and user interactions.</p>
    </section>
  </main>

  <footer>
    <p>&copy; 2026 Specialty Class Rent a Car</p>
  </footer>
</body>
</html>
