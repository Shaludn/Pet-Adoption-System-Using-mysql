<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Adoption Center</title>
    <link rel="stylesheet" href="style.css">
    <style>
       body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background: linear-gradient(135deg, #dbeafe, #fef3c7); /* Soft blue to soft yellow */
    width: 100%;
    height: 100%;
}

/* Header Style */
header {
    background-color: #1e293b; /* Dark slate blue */
    padding: 20px;
    text-align: center;
    color: white;
}

/* Header Text */
header h1 {
    margin: 0;
    font-size: 2em;
    color: #facc15; /* Warm yellow for contrast */
}

/* Navigation Links */
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

/* Adopt Button Style */
.adopt-btn {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #ef4444; /* Soft red */
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.adopt-btn:hover {
    background-color: #f87171; /* Lighter red on hover */
}

/* Pet Gallery Styles */
.pet-gallery {
    display: flex;
    justify-content: center;
    gap: 30px;
    padding: 50px 20px;
    flex-wrap: wrap;
}

/* Pet Card Styling */
.pet-card {
    text-align: center;
    background: rgba(255, 255, 255, 0.85);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    width: 300px;
    transition: transform 0.2s ease;
}

.pet-card:hover {
    transform: translateY(-5px);
}

.pet-card img {
    width: 100%;
    border-radius: 10px;
    margin-bottom: 15px;
}

.pet-card p {
    color: #1e293b;
}

/* Footer Styling */
footer {
    background-color: #1e293b;
    color: white;
    text-align: center;
    padding: 15px 0;
    position: relative;
    bottom: 0;
    width: 100%;
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
                <a href="login.php" class="login-btn">Admin Login</a>
            <?php else: ?>
                <a href="admin_dashboard.php" class="dashboard-btn">Admin Dashboard</a>
                <a href="logout.php" class="logout-btn">Logout</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <section class="pet-gallery">
            <div class="pet-card">
                <img src="uploads/dog.jpg" alt="Cute Dog">
                <h2>Buddy the Dog 🐶</h2>
                <p>Friendly, playful, and loves belly rubs!</p>
                <a href="pets.php?type=dog" class="adopt-btn">Adopt Now</a>
            </div>

            <div class="pet-card">
                <img src="uploads/cat.jpg" alt="Adorable Cat">
                <h2>Whiskers the Cat 🐱</h2>
                <p>Independent, curious, and loves cozy spots.</p>
                <a href="pets.php?type=cat" class="adopt-btn">Adopt Now</a>
            </div>
        </section>
    </main>

    <footer>
        <p>© 2025 Pet Paradise. All rights reserved.</p>
    </footer>
</body>
</html>