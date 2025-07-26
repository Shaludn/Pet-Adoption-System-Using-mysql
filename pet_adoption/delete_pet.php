<?php
session_start();
include 'db.php';

// Ensure only admins can access
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Get pet details
if (isset($_GET['pet_id'])) {
    $pet_id = $_GET['pet_id'];
    $query = "SELECT * FROM pets WHERE pet_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $pet_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pet = $result->fetch_assoc();

    if (!$pet) {
        echo "<p style='color: red;'>Pet not found.</p>";
        exit();
    }
}

// Handle delete confirmation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deleteQuery = "DELETE FROM pets WHERE pet_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $pet_id);

    if ($stmt->execute()) {
        header("Location: manage_pets.php");
        exit();
    } else {
        echo "<p style='color: red;'>Error deleting pet: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Pet - Pet Paradise</title>
    <style>
        body {
            margin: 0;
            background: linear-gradient(135deg, #dbeafe, #fef3c7);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        header {
            background-color: #1e293b;
            color: white;
            text-align: center;
            padding: 20px;
        }

        header h1 {
            margin: 0;
            color: #facc15;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            animation: fadeIn 1s ease-in-out;
        }

        .container h2 {
            text-align: center;
            color: #1d4ed8;
            border-bottom: 2px solid #1d4ed8;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .pet-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .pet-info img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .pet-info p {
            margin: 5px 0;
            font-size: 16px;
            color: #333;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
            display: inline-block;
            margin-top: 15px;
        }

        .btn-danger {
            background-color: #ef4444;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .btn-cancel {
            background-color: #777;
            display: inline-block;
            margin-top: 10px;
        }

        .btn-cancel:hover {
            background-color: #555;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #555;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<header>
    <h1>Pet Paradise 🐾</h1>
</header>

<div class="container">
    <h2>⚠ Confirm Delete</h2>
    <p>Are you sure you want to delete the following pet?</p>

    <div class="pet-info">
        <img src="<?= htmlspecialchars($pet['image']) ?>" alt="Pet Image">
        <p><strong>Name:</strong> <?= htmlspecialchars($pet['name']) ?></p>
        <p><strong>Type:</strong> <?= htmlspecialchars($pet['type']) ?></p>
        <p><strong>Breed:</strong> <?= htmlspecialchars($pet['breed']) ?></p>
        <p><strong>Age:</strong> <?= htmlspecialchars($pet['age']) ?></p>
        <p><strong>Gender:</strong> <?= htmlspecialchars($pet['gender']) ?></p>
        <p><strong>Color:</strong> <?= htmlspecialchars($pet['color']) ?></p>
    </div>

    <form method="post">
        <button type="submit" class="btn btn-danger">Delete Pet</button>
    </form>

    <a href="manage_pets.php" class="btn btn-cancel">Cancel</a>
</div>

</body>
</html>
