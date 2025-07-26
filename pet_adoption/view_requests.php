<?php 
include 'db.php';

$message = ""; // Store messages for user feedback

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pet_id = $_POST['pet_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $date = $_POST['date'];

    if (!empty($name) && !empty($email) && !empty($contact) && !empty($date)) {
        // Prepare SQL to insert appointment request
        $stmt = $conn->prepare("INSERT INTO appointments (pet_id, user_name, user_email, user_contact, appointment_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $pet_id, $name, $email, $contact, $date);
        
        if ($stmt->execute()) {
            $message = "<div class='success-message'>
                            🎉 Thank you for your request! 🎊 <br>
                            We are looking forward to your visit. 😊
                        </div>
                        <script>
                            setTimeout(() => {
                                document.querySelector('.success-message').classList.add('fade-out');
                            }, 4000);
                        </script>";
        } else {
            $message = "<p class='error'>❌ Error submitting request. Please try again.</p>";
        }
    } else {
        $message = "<p class='error'>⚠️ All fields are required!</p>";
    }
}

// Fetch pet details
if (isset($_GET['pet_id']) && is_numeric($_GET['pet_id'])) {
    $pet_id = $_GET['pet_id'];
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
    <title>Request a Visit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Request a Visit for <?= htmlspecialchars($pet['name']); ?></h2>
    
    <?= $message; ?>

    <form method="post">
        <input type="hidden" name="pet_id" value="<?= $pet['pet_id']; ?>">

        <label>Name:</label>
        <input type="text" name="name" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Contact:</label>
        <input type="text" name="contact" required><br>

        <label>Preferred Date:</label>
        <input type="date" name="date" required><br>

        <input type="submit" value="Submit Request">
    </form>
</div>

</body>
</html>

<?php
$pet_stmt->close();
?>
