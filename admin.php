<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #111;
            color: #fff;
        }
        header {
            background-color: #1f1f1f;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        header img {
            height: 40px;
        }
        header h1 {
            margin: 0;
            font-size: 24px;
        }
        .actions {
            display: flex;
            gap: 15px;
        }
        .actions a {
            text-decoration: none;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .actions a:hover {
            background-color: #555;
        }
        main {
            padding: 40px;
        }
        main h2 {
            font-weight: 600;
            margin-bottom: 20px;
        }
        .section {
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .section p {
            margin: 0;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <header>
        <img src="images/image.png" alt="Logo">
        <h1>Admin Dashboard</h1>
        <div class="actions">
            <a href="add_car.php">Add Car</a>
            <a href="remove_car.php">Remove Car</a>
            <a href="release_car.php">Release Car</a>
            <a href="index.php">Logout</a>
        </div>
    </header>
    <main>
        <h2>Welcome, Admin</h2>
        <div class="section">
            <p>You can manage cars, view active rentals, and release cars here. Use the buttons above to navigate.</p>
        </div>
    </main>
</body>
</html>
