<?php
session_start(); // Start the session

// Check if the session contains the user_type_id and it's equal to 1
if (isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 1) {
    // Destroy the session for this user
    session_unset();
    session_destroy();
    header("Location: ../../home/?home"); // Redirect to the home page
    exit(); // Ensure no further code is executed
} else {
    // Optional: Handle cases where user_type_id is not 1
    echo "You are not authorized to perform this action.";
    exit();
}
?>
