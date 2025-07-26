<?php
session_start();
include 'db.php';

// Ensure only admins can access
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle form submission
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $color = $_POST['color'];

    // Image upload
    $uploadDir = "uploads/";
    $image = basename($_FILES['image']['name']);
    $imagePath = $uploadDir . $image;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        $stmt = $conn->prepare("INSERT INTO pets (name, type, breed, age, color, gender, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissss", $name, $type, $breed, $age, $color, $gender, $imagePath);

        if ($stmt->execute()) {
            $message = "<p class='success'>✅ Pet added successfully!</p>";
        } else {
            $message = "<p class='error'>❌ Error adding pet: " . $conn->error . "</p>";
        }
    } else {
        $message = "<p class='error'>❌ Image upload failed.</p>";
    }
}

$result = $conn->query("SELECT * FROM pets");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Pet - Pet Paradise</title>
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
            max-width: 900px;
            margin: 30px auto;
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            animation: fadeIn 1s ease-in-out;
        }

        .container h2 {
            text-align: center;
            color: #16a34a;
            border-bottom: 2px solid #16a34a;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        form input, form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        form input[type="submit"] {
            background-color: #2563eb;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        form input[type="submit"]:hover {
            background-color: #1e40af;
        }

        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
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
    <h2>➕ Add New Pet</h2>

    <?= $message ?>

    <form method="post" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Type:</label>
        <select name="type" required>
            <option value="dog">Dog</option>
            <option value="cat">Cat</option>
        </select>

        <label>Breed:</label>
        <input type="text" name="breed" required>

        <label>Age:</label>
        <input type="number" name="age" step="0.01" required>

        <label>Gender:</label>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>

        <label>Color:</label>
        <input type="text" name="color" required>

        <label>Image:</label>
        <input type="file" name="image" accept="image/*" required>

        <input type="submit" value="Add Pet">
    </form>

    <h2>📋 Existing Pets</h2>
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
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($pet = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($pet['image']) ?>" alt="Pet"></td>
                    <td><?= htmlspecialchars($pet['name']) ?></td>
                    <td><?= htmlspecialchars($pet['type']) ?></td>
                    <td><?= htmlspecialchars($pet['breed']) ?></td>
                    <td><?= htmlspecialchars($pet['age']) ?></td>
                    <td><?= htmlspecialchars($pet['gender']) ?></td>
                    <td><?= htmlspecialchars($pet['color']) ?></td>
                    <td><?= htmlspecialchars($pet['status']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="no-data">No pets available.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
