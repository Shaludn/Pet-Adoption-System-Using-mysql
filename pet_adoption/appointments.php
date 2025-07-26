<?php
session_start();
include 'db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handling search and filter
$whereClause = "1"; // Default query to fetch all appointments
$searchQuery = $statusFilter = $dateFilter = "";

if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $whereClause = "(user_name LIKE '%$searchQuery%' OR user_email LIKE '%$searchQuery%' OR pet_id LIKE '%$searchQuery%')";
}

if (isset($_GET['status'])) {
    $statusFilter = $_GET['status'];
    if ($statusFilter != "") {
        $whereClause .= " AND status = '$statusFilter'";
    }
}

if (isset($_GET['date'])) {
    $dateFilter = $_GET['date'];
    if ($dateFilter != "") {
        $whereClause .= " AND appointment_date LIKE '$dateFilter%'";
    }
}

// Fetch filtered appointments
$result = $conn->query("SELECT * FROM appointments WHERE $whereClause");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Appointments - Pet Paradise</title>
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

        .filters {
            text-align: center;
            margin-bottom: 20px;
        }

        .filters input, .filters select {
            padding: 8px;
            margin-right: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .filters button {
            padding: 8px 16px;
            background-color: #1e3a8a;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .filters button:hover {
            opacity: 0.8;
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

        .no-data {
            text-align: center;
            padding: 20px;
            color: #555;
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

        .complete {
            background-color: #10b981;
        }

        .cancel {
            background-color: #ef4444;
        }

        .action-links a:hover {
            opacity: 0.8;
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
    <h2>📅 Customer Appointments</h2>

    <!-- Search and Filters -->
    <div class="filters">
        <form method="get" action="">
            <input type="text" name="search" placeholder="Search by Name, Email, or Pet ID" value="<?= htmlspecialchars($searchQuery) ?>">
            <input type="date" name="date" value="<?= htmlspecialchars($dateFilter) ?>">
            <select name="status">
                <option value="">All Statuses</option>
                <option value="Pending" <?= ($statusFilter == "Pending") ? "selected" : "" ?>>Pending</option>
                <option value="Completed" <?= ($statusFilter == "Completed") ? "selected" : "" ?>>Completed</option>
                <option value="Cancelled" <?= ($statusFilter == "Cancelled") ? "selected" : "" ?>>Cancelled</option>
            </select>
            <button type="submit">Filter</button>
        </form>
    </div>

    <table>
        <tr>
            <th>User Name</th>
            <th>Email</th>
            <th>Pet ID</th>
            <th>Appointment Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row["user_name"]) ?></td>
                    <td><?= htmlspecialchars($row["user_email"]) ?></td>
                    <td><?= htmlspecialchars($row["pet_id"]) ?></td>
                    <td><?= htmlspecialchars($row["appointment_date"]) ?></td>
                    <td><?= htmlspecialchars($row["status"]) ?></td>
                    <td class="action-links">
                        <?php if ($row['status'] == 'Scheduled'): ?>
                            <a href="mark_appointment.php?appointment_id=<?= $row['appointment_id'] ?>&status=Completed" class="complete" onclick="return confirm('Mark this appointment as completed?');">Complete</a>
                            <a href="mark_appointment.php?appointment_id=<?= $row['appointment_id'] ?>&status=Cancelled" class="cancel" onclick="return confirm('Are you sure you want to cancel this appointment?');">Cancel</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="no-data">No appointments found.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
