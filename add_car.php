<?php
session_start();
require_once 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_SESSION['role'] === 'admin') {
    $fields = ['manufacturer', 'brand', 'model', 'registration_plate', 'type', 'fuel_type', 'transmission', 'mileage', 'notes'];
    $data = [];
    foreach ($fields as $field) {
        $data[$field] = $_POST[$field] ?? '';
    }

    // Handle file upload
    $uploadDir = 'images/';
    $filename = basename($_FILES['image']['name']);
    $targetFile = $uploadDir . uniqid() . '_' . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $stmt = $pdo->prepare("
            INSERT INTO cars (manufacturer, brand, model, registration_plate, type, fuel_type, transmission, mileage, notes, image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['manufacturer'], $data['brand'], $data['model'], $data['registration_plate'], $data['type'],
            $data['fuel_type'], $data['transmission'], $data['mileage'], $data['notes'], $targetFile
        ]);
    }
}

header("Location: admin.php");
exit;