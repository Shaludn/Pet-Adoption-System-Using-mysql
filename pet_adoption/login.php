    <?php
    session_start();
    include 'db.php';

    $error_message = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT admin_id, password FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            if ($password === $admin['password']) { // No hashing
                $_SESSION['admin_id'] = $admin['admin_id'];
                header("Location: admin_dashboard.php");
                exit();
            } else {
                $error_message = "⚠ Incorrect password.";
            }
        } else {
            $error_message = "🚫 Access denied. Only admins can log in.";
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login - Pet Paradise</title>
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

            .section-container {
                width: 90%;
                max-width: 400px;
                margin: 50px auto;
                padding: 30px;
                background: rgba(255, 255, 255, 0.95);
                border-radius: 20px;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
                animation: fadeInUp 1s ease-in-out;
                text-align: center;
            }

            .section-container h2 {
                font-size: 26px;
                margin-bottom: 20px;
                font-weight: bold;
                color: #2563eb;
                padding-bottom: 8px;
                border-bottom: 2px solid #2563eb;
            }

            input[type="email"], input[type="password"] {
                width: 100%;
                padding: 10px;
                margin: 12px 0;
                border: 1px solid #ccc;
                border-radius: 8px;
                font-size: 16px;
            }

            input[type="submit"] {
                background: #2563eb;
                color: white;
                border: none;
                padding: 12px;
                width: 100%;
                border-radius: 8px;
                font-size: 18px;
                font-weight: bold;
                cursor: pointer;
                transition: 0.3s;
            }

            input[type="submit"]:hover {
                background: #1e40af;
            }

            .error-message {
                color: red;
                font-weight: bold;
                margin-top: 10px;
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

    <div class="section-container">
        <h2>🔐 Admin Login</h2>
        
        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?= $error_message; ?></p>
        <?php endif; ?>

        <form method="post">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <input type="submit" value="Login">
        </form>
    </div>

    <footer>
        <p>© 2025 Pet Paradise. All rights reserved.</p>
    </footer>

    </body>
    </html>
