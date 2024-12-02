<?php
session_start();
include "../../config/db.php"; // Include database connection

// Check if the session contains a valid user ID
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Update login status to 0 (logged out)
    $update_status_sql = "UPDATE user SET reset_token = 0 WHERE user_id = ?";
    $status_stmt = $con->prepare($update_status_sql);
    $status_stmt->bind_param("i", $user_id);
    $status_stmt->execute();

    // Clear session and destroy it
    session_unset();
    session_destroy();

    // Redirect to home page
    header("Location: ../../home/?home");
    exit();
} else {
    // Handle invalid or missing session
    echo "Unauthorized logout attempt or no session found.";
    exit();
}

?>