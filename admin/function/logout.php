<?php
session_start();
include "../../config/db.php"; // Ensure this includes your database connection

// Function to log out user from all devices
function invalidate_all_sessions($trans_no, $con) {
    $sql = "UPDATE reservation SET adult = 0 WHERE trans_no = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $trans_no);
    $stmt->execute();
}

// Check if the user is logged in and has a valid session
if (isset($_SESSION['uname'])) {
    $uname = $_SESSION['uname'];

    // Call the function to invalidate sessions, passing necessary parameters
    // You may need to use the session user ID or other identifying information to specify the session to invalidate.
    // Assuming trans_no can be determined from the session or database.
    // Example: $trans_no = $_SESSION['trans_no'];
    // invalidate_all_sessions($trans_no, $con);

    // For demonstration purposes, replace with your logic to retrieve trans_no or use user_id if needed
}

// Destroy all session variables and end the session
session_unset();
session_destroy();

// Clear the session cookie for added security
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Redirect to the home page after logout
header("Location: ../../home/?home");
exit();
?>
