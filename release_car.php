<?php
session_start();
require_once 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['car_id'], $_SESSION['user_id'])) {
    $car_id = $_POST['car_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("UPDATE rentals SET return_date = NOW() WHERE car_id = ? AND user_id = ? AND return_date IS NULL");
    $stmt->execute([$car_id, $user_id]);
}

header("Location: user.php");
exit;