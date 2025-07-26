<?php
session_start();
include 'db.php';

// Ensure only admins can access
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// ✅ Check for pet_id in URL
if (isset($_GET['pet_id']) && is_numeric($_GET['pet_id'])) {
    $pet_id = intval($_GET['pet_id']);

    // ✅ Update pet status to "Adopted"
    $stmt = $conn->prepare("UPDATE pets SET status = 'Adopted' WHERE pet_id = ?");
    $stmt->bind_param("i", $pet_id);

    if ($stmt->execute()) {
        // ✅ Redirect with success message
        header("Location: manage_pets.php?msg=Pet marked as adopted");
        exit();
    } else {
        // ✅ Redirect with error message
        header("Location: manage_pets.php?error=Failed to update pet status");
        exit();
    }
} else {
    // ✅ Invalid pet_id handling
    header("Location: manage_pets.php?error=Invalid pet ID");
    exit();
}
?>
