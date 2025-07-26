<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch adopted pets
$stmt = $conn->prepare("SELECT * FROM pets WHERE status = 'adopted' ORDER BY pet_id DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopted Pets - Pet Paradise</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #dbeafe, #fef3c7);
            width: 100%;
            height: 100%;
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

        main {
            padding: 30px;
            flex: 1;
        }

        .table-container {
            max-width: 1100px;
            margin: auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #22c55e;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #16a34a;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f3f4f6;
        }

        img.pet-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 25px;
            background: #3b82f6;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background: #2563eb;
        }

        footer {
            background-color: #1e293b;
            color: white;
            text-align: center;
            padding: 15px 0;
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome to Pet Paradise! 🐾</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About Us</a>
        <a href="admin_dashboard.php">Admin Dashboard</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<main>
    <div class="table-container">
        <h2>🐾 Adopted Pets List</h2>

        <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Pet ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Breed</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['pet_id']); ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><img src="<?= htmlspecialchars($row['image']); ?>" class="pet-img" alt="Pet Image"></td>
                <td><?= htmlspecialchars($row['breed']); ?></td>
                <td><?= htmlspecialchars($row['age']); ?></td>
                <td><?= htmlspecialchars($row['gender']); ?></td>
                <td><strong style="color:green;">Adopted</strong></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
            <p style="text-align: center;">No pets have been adopted yet.</p>
        <?php endif; ?>

        <div style="text-align:center;">
            <a class="back-btn" href="admin_dashboard.php">⬅ Back to Dashboard</a>
        </div>
    </div>
</main>

<footer>
    <p>© 2025 Pet Paradise. All rights reserved.</p>
</footer>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
