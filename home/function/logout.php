<?php
session_start(); // Start the session

// Include the database connection
include "../../config/db.php";

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];

    // Clear the reset_token in the database
    $update_sql = "UPDATE user SET reset_token = NULL WHERE user_id = ?";
    $stmt = $con->prepare($update_sql);
    $stmt->bind_param("i", $user_id);

    if (!$stmt->execute()) {
        // Handle any database errors
        $_SESSION['notify'] = 'error_clearing_token';
    }
    $stmt->close();
}

// Clear session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the home page
header("Location: ../?home");
exit();
?>
