<?php
include 'db.php';

if (isset($_GET['appointment_id']) && isset($_GET['status'])) {
    $appointment_id = intval($_GET['appointment_id']);
    $status = $_GET['status'];

    // Update appointment status
    $stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE appointment_id = ?");
    $stmt->bind_param("si", $status, $appointment_id);

    if ($stmt->execute()) {
        header("Location: appointments.php?msg=Appointment updated successfully");
        exit();
    } else {
        echo "Error updating status: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
