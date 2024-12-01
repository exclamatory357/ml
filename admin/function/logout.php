<?php
session_start();    // Start the session

// Function to log out a user based on their user_type_id
function logout_user_based_on_type($target_user_type_id) {
    // Check if the user session is set and if their user_type_id matches the target
    if (isset($_SESSION['type_id']) && $_SESSION['type_id'] == $target_user_type_id) {
        // Destroy the session data for the user
        session_unset();
        session_destroy();
        header("Location: ../../home/?home");  // Redirect to home after logging out
        exit();
    }
}

// Example: Log out users with a specific user_type_id, e.g., 2
logout_user_based_on_type(1);
?>
