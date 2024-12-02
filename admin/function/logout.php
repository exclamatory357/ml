<?php
session_start();
include "../../config/db.php"; // Include database connection

// Function to clear all session-like entries for a specific trans_no (acting as type_id)
function logout_all_sessions($trans_no, $con) {
    // Use the reservation table to clear sessions, assuming trans_no is the target column
    $sql = "DELETE FROM reservation WHERE trans_no = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $trans_no);
    $stmt->execute();
}

// Check if the session contains the correct user type ID
if (isset($_SESSION['type_id']) && $_SESSION['type_id'] == 1) {
    // Get the user type ID from the session
    $trans_no = $_SESSION['type_id'];

    // Clear all session-like entries for this user type
    logout_all_sessions($trans_no, $con);

    // Destroy the current session
    session_unset();
    session_destroy();

    // Redirect to the home page
    header("Location: ../../home/?home");
    exit();
} else {
    // Handle cases where the session is invalid or unauthorized
    echo "Unauthorized logout attempt or no session found.";
    exit();
}
?>
