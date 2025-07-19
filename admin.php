

<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Fetch cars not currently rented (available for removal)
$availableCars = $pdo->query("
    SELECT * FROM cars 
    WHERE id NOT IN (SELECT car_id FROM rentals WHERE return_date IS NULL)
")->fetchAll();

// Fetch rented cars with user info
$rentedCars = $pdo->query("
    SELECT cars.*, users.username FROM cars
    JOIN rentals ON cars.id = rentals.car_id
    JOIN users ON rentals.user_id = users.id
    WHERE rentals.return_date IS NULL
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
</head>
<body>
    <div class="dashboard">
        <h2>Admin Panel</h2>

        <section>
            <h3>Available Cars</h3>
            <table class="car-table">
                <thead>
                    <tr><th>Model</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($availableCars as $car): ?>
                        <tr class="car-row" data-id="<?= $car['id'] ?>">
                            <td><?= $car['brand'] . " " . $car['model'] ?></td>
                            <td>
                                <form method="POST" action="remove_car.php">
                                    <input type="hidden" name="car_id" value="<?= $car['id'] ?>">
                                    <button type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <tr class="details" style="display:none">
                            <td colspan="2"><?= $car['notes'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section>
            <h3>Currently Rented Cars</h3>
            <table class="car-table">
                <thead>
                    <tr><th>Model</th><th>Rented By</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($rentedCars as $car): ?>
                        <tr class="car-row" data-id="<?= $car['id'] ?>">
                            <td><?= $car['brand'] . " " . $car['model'] ?></td>
                            <td><?= htmlspecialchars($car['username']) ?></td>
                        </tr>
                        <tr class="details" style="display:none">
                            <td colspan="2"><?= $car['notes'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section>
            <h3>Add a Car</h3>
            <form method="POST" action="add_car.php" enctype="multipart/form-data">
                <input type="text" name="manufacturer" placeholder="Manufacturer" required>
                <input type="text" name="brand" placeholder="Brand" required>
                <input type="text" name="model" placeholder="Model" required>
                <input type="text" name="registration_plate" placeholder="Registration Plate" required>
                <input type="text" name="type" placeholder="Type" required>
                <input type="text" name="fuel_type" placeholder="Fuel Type" required>
                <input type="text" name="transmission" placeholder="Transmission" required>
                <input type="number" name="mileage" placeholder="Mileage" required>
                <textarea name="notes" placeholder="Notes"></textarea>
                <input type="file" name="image" accept="image/*" required>
                <button type="submit">Add Car</button>
            </form>
        </section>
    </div>
</body>
</html>