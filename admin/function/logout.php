<?php
session_start(); // Start the session

// Check if the session contains the correct user type ID and it's equal to 1
if (isset($_SESSION['type_id']) && $_SESSION['type_id'] == 1) {
    // Destroy the session for this user
    session_unset();
    session_destroy();
    header("Location: ../../home/?home"); // Redirect to the home page
    exit(); // Ensure no further code is executed
} else {
    // Handle cases where the session is invalid or unauthorized
    echo "Unauthorized logout attempt or no session found.";
    exit();
}
?>
