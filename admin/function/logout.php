<?php
session_start();
include "../../config/db.php"; // Include database connection

// Function to log out all sessions for a specific user type ID
function logout_all_sessions_by_user_type($trans_no, $con) {
    // Delete all sessions for users with the specified user_type_id
    $sql = "DELETE FROM reservation WHERE trans_no = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $trans_no);
    $stmt->execute();
}

// Check if the session contains the correct user type ID
if (isset($_SESSION['type_id']) && $_SESSION['type_id'] == 1) {
    // Get the user_type_id from the session
    $trans_no = $_SESSION['type_id'];

    // Log out all sessions for this user type
    logout_all_sessions_by_user_type($trans_no, $con);

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
