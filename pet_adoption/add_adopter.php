<?php
include 'db.php';

$search = $_GET['search'] ?? '';

$sql = "
    SELECT a.name AS adopter_name, a.address, a.phone, a.email,
           p.name AS pet_name, p.image
    FROM adopters a
    JOIN appointments ap ON a.email = ap.email
    JOIN pets p ON ap.pet_id = p.id
    WHERE a.name LIKE ? OR p.name LIKE ?
    ORDER BY a.name ASC
";




$like = "%$search%";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Adopters - Pet Paradise</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
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

        .container {
            padding: 20px;
            max-width: 1000px;
            margin: 20px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #16a34a;
            margin-bottom: 20px;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            width: 300px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .adopter-card {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        .adopter-card img {
            width: 100px;
            height: 100px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid #2563eb;
        }

        .info {
            flex: 1;
        }

        .info h3 {
            margin: 0;
            color: #2563eb;
        }

        .info p {
            margin: 5px 0;
        }

        footer {
            background-color: #1e293b;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<header>
    <h1>Pet Paradise 🐾</h1>
</header>

<div class="container">
    <h2>📋 Adopter Records</h2>
    <form method="get">
        <input type="text" name="search" placeholder="Search by adopter or pet name" value="<?= htmlspecialchars($search) ?>">
    </form>

    <?php while ($row = $result->fetch_assoc()): ?>
    <div class="adopter-card">
        <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Pet Photo">
        <div class="info">
            <h3><?= htmlspecialchars($row['adopter_name']) ?></h3>
            <p>📍 <?= htmlspecialchars($row['address']) ?></p>
            <p>📞 <?= htmlspecialchars($row['phone']) ?></p>
            <p>✉️ <?= htmlspecialchars($row['email']) ?></p>
            <p>🐾 Adopted Pet: <strong><?= htmlspecialchars($row['pet_name']) ?></strong></p>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<footer>
    <p>© 2025 Pet Paradise. All rights reserved.</p>
</footer>

</body>
</html>
