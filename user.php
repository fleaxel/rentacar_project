<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Fetch cars from DB
function fetchCars($pdo, $query, $params = []) {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// Cars available for rent
$availableCars = fetchCars($pdo, "SELECT * FROM cars WHERE id NOT IN (SELECT car_id FROM rentals WHERE return_date IS NULL)");

// Cars currently rented by user
$currentRentals = fetchCars($pdo, "SELECT cars.* FROM cars 
    JOIN rentals ON cars.id = rentals.car_id 
    WHERE rentals.user_id = ? AND rentals.return_date IS NULL", [$user_id]);

// Rental history
$pastRentals = fetchCars($pdo, "SELECT cars.* FROM cars 
    JOIN rentals ON cars.id = rentals.car_id 
    WHERE rentals.user_id = ? AND rentals.return_date IS NOT NULL", [$user_id]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome <?= htmlspecialchars($username) ?></title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
</head>
<body>
    <div class="dashboard">
        <h2>Welcome, <?= htmlspecialchars($username) ?></h2>

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
                                <form method="POST" action="rent_car.php">
                                    <input type="hidden" name="car_id" value="<?= $car['id'] ?>">
                                    <button type="submit">Rent</button>
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
            <h3>Cars You're Renting</h3>
            <table class="car-table">
                <thead>
                    <tr><th>Model</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($currentRentals as $car): ?>
                        <tr class="car-row" data-id="<?= $car['id'] ?>">
                            <td><?= $car['brand'] . " " . $car['model'] ?></td>
                            <td>
                                <form method="POST" action="release_car.php">
                                    <input type="hidden" name="car_id" value="<?= $car['id'] ?>">
                                    <button type="submit">Release</button>
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
            <h3>Rental History</h3>
            <table class="car-table">
                <thead>
                    <tr><th>Model</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($pastRentals as $car): ?>
                        <tr class="car-row" data-id="<?= $car['id'] ?>">
                            <td><?= $car['brand'] . " " . $car['model'] ?></td>
                        </tr>
                        <tr class="details" style="display:none">
                            <td><?= $car['notes'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>