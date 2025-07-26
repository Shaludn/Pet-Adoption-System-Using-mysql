<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pet_id = intval($_POST['pet_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $date = $_POST['date'];
    $time = $_POST['time'];

    $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : NULL;

    if (empty($name) || empty($email) || empty($contact) || empty($date) || empty($time)) {
        header("Location: request_visit.php?pet_id=$pet_id&error=All fields are required");
        exit();
    } elseif (strtotime($date) < strtotime(date('Y-m-d'))) {
        header("Location: request_visit.php?pet_id=$pet_id&error=You cannot select a past date");
        exit();
    } elseif ($time < "09:00" || $time > "19:00") {
        header("Location: request_visit.php?pet_id=$pet_id&error=Please select a time between 9:00 AM and 7:00 PM");
        exit();
    } else {
        $check_stmt = $conn->prepare("SELECT * FROM appointments WHERE pet_id = ? AND user_email = ?");
        $check_stmt->bind_param("is", $pet_id, $email);
        $check_stmt->execute();
        $existing = $check_stmt->get_result();

        if ($existing->num_rows > 0) {
            header("Location: request_visit.php?pet_id=$pet_id&error=You have already requested a visit for this pet");
            exit();
        } else {
            $stmt = $conn->prepare("INSERT INTO appointments (pet_id, user_name, user_email, user_contact, appointment_date, appointment_time) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssss", $pet_id, $name, $email, $contact, $date, $time);

            if ($stmt->execute()) {
                header("Location: thank_you.php");
                exit();
            } else {
                header("Location: request_visit.php?pet_id=$pet_id&error=Error submitting request");
                exit();
            }
        }
    }
}

// Fetch pet
if (isset($_GET['pet_id']) && is_numeric($_GET['pet_id'])) {
    $pet_id = intval($_GET['pet_id']);
    $pet_stmt = $conn->prepare("SELECT * FROM pets WHERE pet_id = ?");
    $pet_stmt->bind_param("i", $pet_id);
    $pet_stmt->execute();
    $pet = $pet_stmt->get_result()->fetch_assoc();
} else {
    die("<p class='error'>⚠️ Invalid pet selection.</p>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Visit - Pet Paradise</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #dbeafe, #fef3c7);
            display: flex;
            flex-direction: column;
        }
        header {
            background-color: #1e293b;
            padding: 20px;
            text-align: center;
            color: white;
        }
        header h1 {
            color: #facc15;
            margin: 0;
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
        .visit-form-container {
            background: white;
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #1e293b;
        }
        .error {
            background-color: #fde2e1;
            color: #b91c1c;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
        }
        form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="date"], input[type="time"] {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }
        input[type="submit"] {
            background-color: #22c55e;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 8px;
            margin-top: 20px;
            cursor: pointer;
            font-weight: bold;
        }
        input[type="submit"]:hover {
            background-color: #16a34a;
        }
        footer {
            background-color: #1e293b;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: auto;
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
                <a href="login.php">Admin Login</a>
            <?php else: ?>
                <a href="admin.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="visit-form-container">
        <h2>Schedule a Visit for <?= htmlspecialchars($pet['name']); ?></h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="error"><?= htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="pet_id" value="<?= $pet['pet_id']; ?>">

            <label>Your Name:</label>
            <input type="text" name="name" required>

            <label>Email Address:</label>
            <input type="email" name="email" required>

            <label>Contact Number:</label>
            <input type="text" name="contact" required>

            <label>Preferred Visit Date:</label>
            <input type="date" name="date" id="datePicker" required>

            <label>Preferred Time (9:00 AM to 7:00 PM):</label>
            <input type="time" name="time" min="09:00" max="19:00" required>

            <input type="submit" value="Submit Visit Request">
        </form>
    </div>

    <footer>
        <p>© 2025 Pet Paradise. All rights reserved.</p>
    </footer>

    <script>
        // Disable past dates
        document.getElementById("datePicker").setAttribute("min", new Date().toISOString().split("T")[0]);
    </script>
</body>
</html>

<?php
$pet_stmt->close();
?>
