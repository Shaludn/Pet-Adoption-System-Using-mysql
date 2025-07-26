<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$pet_id = isset($_GET['pet_id']) ? intval($_GET['pet_id']) : 0; // Ensure pet_id is an integer

if ($pet_id <= 0) {
    die("Invalid pet ID.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if an adoption request already exists
    $stmt = $conn->prepare("SELECT * FROM adoption_requests WHERE user_id = ? AND pet_id = ?");
    $stmt->bind_param("ii", $user_id, $pet_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "You have already submitted an adoption request for this pet.";
    } else {
        // Insert adoption request securely
        $stmt = $conn->prepare("INSERT INTO adoption_requests (user_id, pet_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $pet_id);

        if ($stmt->execute()) {
            echo "Adoption request submitted successfully!";
        } else {
            echo "Error submitting request. Please try again.";
        }
    }

    $stmt->close();
}
?>

<h2>Adopt This Pet</h2>
<form method="post">
    <input type="submit" value="Submit Adoption Request">
</form>
