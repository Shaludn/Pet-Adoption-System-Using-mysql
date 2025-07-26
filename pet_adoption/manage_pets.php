<?php
session_start();
include 'db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all pets from the database
$result = $conn->query("SELECT * FROM pets ORDER BY type ASC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Pets - Pet Paradise</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            max-width: 1000px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #1e3a8a;
            color: white;
        }

        img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
        }

        .action-links a {
            margin: 0 4px;
            padding: 6px 12px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            display: inline-block;
            font-size: 0.9rem;
        }

        .adopt {
            background-color: #10b981;
        }

        .delete {
            background-color: #ef4444;
        }

        .action-links a:hover {
            opacity: 0.9;
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
    <h2>📋 Manage Pets</h2>

    <table>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Type</th>
            <th>Breed</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Color</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($pet = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($pet['image']) ?>" alt="Pet Image"></td>
                    <td><?= htmlspecialchars($pet['name']) ?></td>
                    <td><?= htmlspecialchars($pet['type']) ?></td>
                    <td><?= htmlspecialchars($pet['breed']) ?></td>
                    <td><?= htmlspecialchars($pet['age']) ?></td>
                    <td><?= htmlspecialchars($pet['gender']) ?></td>
                    <td><?= htmlspecialchars($pet['color']) ?></td>
                    <td><?= htmlspecialchars($pet['status']) ?></td>
                    <td class="action-links">
                        <a href="mark_adopted.php?pet_id=<?= $pet['pet_id'] ?>" class="adopt" onclick="return confirm('Mark this pet as adopted?');">Adopted</a>
                        <a href="delete_pet.php?pet_id=<?= $pet['pet_id'] ?>" class="delete" onclick="return confirm('Are you sure you want to delete this pet?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="9" class="no-data">No pets found.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
