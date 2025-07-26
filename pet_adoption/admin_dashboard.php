<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Pet Paradise</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #dbeafe, #fef3c7);
        }

        header {
            background-color: #1e293b;
            padding: 20px;
            text-align: center;
            color: white;
        }

        header h1 {
            margin: 0;
            font-size: 2em;
            color: #facc15;
        }

        .dashboard-container {
            width: 90%;
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            animation: fadeInUp 1s ease-in-out;
            text-align: center;
        }

        .dashboard-container h2 {
            font-size: 26px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #16a34a;
            padding-bottom: 8px;
            border-bottom: 2px solid #16a34a;
        }

        .menu a {
            display: block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
            transition: background 0.3s;
        }

        .menu a:hover {
            background: #1e40af;
        }

        .menu a.logout {
            background-color: #dc2626;
        }

        .menu a.logout:hover {
            background-color: #991b1b;
        }

        footer {
            background-color: #1e293b;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: auto;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<header>
    <h1>Pet Paradise 🐾</h1>
</header>

<div class="dashboard-container">
    <h2>👩‍💼 Admin Dashboard</h2>
    <div class="menu">
        <a href="add_pet.php">➕ Add Pet</a>
<a href="manage_pets.php">📋 Manage Pets</a>
<a href="appointments.php">📅 View Appointments</a>
<a href="add_adopter.php">👤 View Adopters</a>
<a href="adopted_pets.php">🐾 Adopted Pets</a>
<a href="logout.php" class="logout">🚪 Logout</a>

    </div>
</div>

<footer>
    <p>© 2025 Pet Paradise. All rights reserved.</p>
</footer>

</body>
</html>
