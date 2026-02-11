<!-- File location: index.php -->
<!-- Replace current index.php contents with this updated version -->

<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Specialty Class Rent-a-Car</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <header class="header">
      <img src="images/image.png" alt="Logo" class="logo">
      <h1 class="title">Specialty Class Rent-a-Car</h1>
    </header>

    <main class="main-panel">
      <div class="login-card">
        <h2>Login</h2>
        <form method="post" action="user.php">
          <label for="username">Username</label>
          <input type="text" name="username" required>

          <label for="password">Password</label>
          <input type="password" name="password" required>

          <button type="submit">Login</button>
        </form>
      </div>
    </main>

    <footer class="footer">
      <p>&copy; <?php echo date('Y'); ?> Specialty Class Rent-a-Car</p>
    </footer>
  </div>
</body>
</html>
