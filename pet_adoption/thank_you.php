<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Thank You - Pet Paradise</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      background: linear-gradient(135deg, #fdf2f8, #ecfeff);
      display: flex;
      flex-direction: column;
    }

    header {
      background-color: #1e293b;
      padding: 20px;
      text-align: center;
    }

    header h1 {
      color: #facc15;
      font-size: 2rem;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    .thank-you-container {
      background: white;
      max-width: 650px;
      margin: 80px auto;
      padding: 50px 40px;
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
      text-align: center;
      position: relative;
    }

    .thank-you-container::before {
      content: "🎊";
      font-size: 4rem;
      position: absolute;
      top: -30px;
      left: 20px;
      transform: rotate(-10deg);
    }

    .thank-you-container::after {
      content: "🐶";
      font-size: 4rem;
      position: absolute;
      top: -30px;
      right: 20px;
      transform: rotate(10deg);
    }

    h2 {
      color: #10b981;
      font-size: 2rem;
      margin-bottom: 15px;
    }

    p {
      font-size: 1.2rem;
      color: #374151;
      line-height: 1.6;
    }

    .highlight {
      color: #ef4444;
      font-weight: bold;
    }

    .home-btn {
      display: inline-block;
      margin-top: 30px;
      padding: 12px 28px;
      background-color: #6366f1;
      color: white;
      text-decoration: none;
      border-radius: 10px;
      font-weight: bold;
      font-size: 1rem;
      transition: background 0.3s ease;
    }

    .home-btn:hover {
      background-color: #4f46e5;
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
  <h1>Pet Paradise 🐾</h1>
</header>

<div class="thank-you-container">
  <h2>🎉 Thank You for Scheduling a Visit!</h2>
  <p>
    We're absolutely thrilled that you're interested in giving a loving home to one of our adorable companions. 🐕🐾
  </p>
  <p>
    Our team has received your request and will contact you shortly with the next steps. We can’t wait to help you meet your future furry friend! 💖
  </p>
  <p class="highlight">Adopting is an act of love — thank you for choosing to make a difference. 🏡✨</p>
  <a href="index.php" class="home-btn">Back to Home</a>
</div>

<footer>
  <p>© 2025 Pet Paradise. All rights reserved.</p>
</footer>

</body>
</html>
