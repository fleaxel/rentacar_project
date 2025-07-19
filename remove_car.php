<?php
session_start();
require_once 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_SESSION['role'] === 'admin') {
    $car_id = $_POST['car_id'];

    // Ensure the car is NOT currently rented
    $stmt = $pdo->prepare("SELECT * FROM rentals WHERE car_id = ? AND return_date IS NULL");
    $stmt->execute([$car_id]);

    if ($stmt->rowCount() === 0) {
        $pdo->prepare("DELETE FROM cars WHERE id = ?")->execute([$car_id]);
    }
}

header("Location: admin.php");
exit;