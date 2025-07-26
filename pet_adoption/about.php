<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Pet Paradise</title>
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

        .section-container {
            width: 90%;
            max-width: 1100px;
            margin: 40px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            animation: fadeInUp 1s ease-in-out;
        }

        h2 {
            font-size: 30px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
            padding-bottom: 6px;
            border-bottom: 3px solid #2563eb;
            color: #2563eb;
        }

        .helpdesk h2 {
            color: #0077cc;
        }

        p {
            font-size: 16px;
            color: #444;
            line-height: 1.8;
            margin-bottom: 15px;
            text-align: center;
        }

        footer {
            background-color: #1e293b;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: auto;
        }
        footer p{
            color: white
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Pet Paradise 🐾</h1>
</header>

<div class="section-container">
    <h2>🐾 About Pet Paradise</h2>
    <p>
        Welcome to <strong>Pet Paradise</strong>, where we connect loving families with adorable pets in need of a home. 
        Our mission is to ensure every pet finds a forever home filled with love and care.
    </p>
    <p>
        We provide a safe, nurturing environment for rescued animals and work tirelessly to match them with the perfect owners. 
        Whether you're looking for a playful pup or a cuddly kitten, we are here to help you find your new best friend! ❤️
    </p>
    <p>
        Join us in making a difference—adopt, don’t shop! 🏡🐶🐱
    </p>
</div>

<div class="section-container helpdesk">
    <h2>📞 Helpdesk</h2>
    <p>Have questions or need help? Reach out to us anytime!</p>
    <p><strong>📍 Address:</strong> 123 Pet Lane, Paws City, PC 45678</p>
    <p><strong>📧 Email:</strong> support@petparadise.com</p>
    <p><strong>📱 Phone:</strong> +91 98765 43210</p>
</div>

<footer>
    <p>© 2025 Pet Paradise. All rights reserved.</p>
</footer>

</body>
</html>
