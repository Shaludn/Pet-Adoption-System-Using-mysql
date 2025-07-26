<?php
session_start();
include 'db.php';

// Ensure a default type is set
$type = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : 'dog';

$stmt = $conn->prepare("SELECT * FROM pets WHERE type = ? AND status = 'Available'");
if ($stmt) {
    $stmt->bind_param("s", $type);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available <?= htmlspecialchars(ucfirst($type)) ?>s</title>
    <link rel="stylesheet" href="style.css">
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

        nav a {
            margin: 0 15px;
            color: #f1f5f9;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
            color: #facc15;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: 40px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        h2 {
            font-size: 30px;
            color: #2563eb;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            text-transform: uppercase;
            border-bottom: 3px solid #2563eb;
            display: inline-block;
            padding-bottom: 6px;
        }

        .pet-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
        }

        .pet-card {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 16px;
            width: 250px;
            height: 350px;
            text-align: center;
            padding: 16px;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .pet-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .pet-image img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 12px;
        }

        .pet-info {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.96);
            padding: 20px;
            text-align: left;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            pointer-events: none;
            font-size: 15px;
            line-height: 1.6;
            border-radius: 16px;
        }

        .pet-card:hover .pet-info {
            opacity: 1;
        }

        .request-btn {
            display: inline-block;
            background-color: #ef4444;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 10px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            position: relative;
            z-index: 10;
        }

        .request-btn:hover {
            background-color: #f87171;
        }

        .no-pets {
            font-size: 18px;
            font-weight: bold;
            color: #4b5563;
            margin-top: 30px;
            text-align: center;
        }

        footer {
            background-color: #1e293b;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: auto;
        }

        .back-btn {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            padding: 10px 20px;
            margin-top: 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }

        .back-btn:hover {
            background-color: #60a5fa;
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome to Pet Paradise! 🐾</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About Us</a>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="login.php" class="login-btn">Admin Login</a>
        <?php else: ?>
            <a href="admin.php" class="dashboard-btn">Admin Dashboard</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        <?php endif; ?>
    </nav>
</header>

<div class="container">
    <h2>Available <?= htmlspecialchars(ucfirst($type)) ?>s</h2>

    <?php
    if ($result && $result->num_rows > 0) {
        echo "<div class='pet-container'>";
        while ($pet = $result->fetch_assoc()) {
            echo "<div class='pet-card'>
                    <div class='pet-image'>
                        <img src='" . htmlspecialchars($pet['image']) . "' alt='" . htmlspecialchars($pet['breed']) . "'>
                    </div>
                    <div class='pet-info'>
                        <h3>" . htmlspecialchars($pet['breed']) . "</h3>
                        <p><strong>Name:</strong> " . htmlspecialchars($pet['name']) . "</p>
                        <p><strong>Gender:</strong> " . htmlspecialchars($pet['gender']) . "</p>
                        <p><strong>Age:</strong> " . htmlspecialchars($pet['age']) . " years</p>
                        <p><strong>Color:</strong> " . htmlspecialchars($pet['color']) . "</p>
                    </div>
                    <a href='request_visit.php?pet_id=" . htmlspecialchars($pet['pet_id']) . "' class='request-btn'>Request a Visit</a>
                  </div>";
        }
        echo "</div>";
    } else {
        echo "<p class='no-pets'>No available " . htmlspecialchars(ucfirst($type)) . "s at the moment.</p>";
    }

    if ($stmt) {
        $stmt->close();
    }
    ?>
    <div style="text-align:center;">
        <a href="index.php" class="back-btn">← Back to Home</a>
    </div>
</div>

<footer>
    <p>© 2025 Pet Paradise. All rights reserved.</p>
</footer>

</body>
</html>
