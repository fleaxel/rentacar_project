<?php
require_once 'includes/db_connect.php';

$name = $email = $address = $password = $confirm_password = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $activation_token = bin2hex(random_bytes(16));

        $stmt = $conn->prepare("INSERT INTO users (name, email, address, password, role, is_active, activation_token) VALUES (?, ?, ?, ?, 'user', 0, ?)");
        $stmt->bind_param("sssss", $name, $email, $address, $hashed, $activation_token);

        if ($stmt->execute()) {
            $activation_link = "http://localhost/rentacar/activate.php?email=" . urlencode($email) . "&token=$activation_token";
            $message = "Account created! Please activate: <a href='$activation_link'>Activate Now</a>";
        } else {
            $message = "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Rent-A-Car</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="login-container">
  <h2>Register</h2>
  <form method="POST" action="">
    <input type="text" name="name" placeholder="Full Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="address" placeholder="Address" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
    <button type="submit">Register</button>
  </form>
  <p><?php echo $message; ?></p>
  <a href="index.php">Back to login</a>
</div>
</body>
</html>