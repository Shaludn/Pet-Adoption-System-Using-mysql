<?php
session_start(); // Start session

// Destroy all session data
session_destroy();

// Redirect to the homepage (index.php)
header("Location: index.php");
exit();
?>
