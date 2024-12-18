<?php
session_start(); // Start the session

// Include the database connection file
include "../../config/db.php";

// Check if the user is logged in and has a valid session
if (isset($_SESSION['user_id'])) {
    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];

    // Update the database to clear the reset_token
    $update_sql = "UPDATE user SET reset_token = NULL WHERE user_id = ?";
    $stmt = $con->prepare($update_sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // If successful, continue with session clearing and logout
        $_SESSION = array(); // Clear all session variables

        // If you want to destroy the session cookie, you can do this:
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroy the session
        session_destroy();

        // Redirect to the home page after logout
        header("Location: ../../home/?home");
        exit(); // Ensure no further code is executed
    } else {
        // Handle any errors during the update
        $_SESSION["notify"] = "error_clearing_token";
        header("Location: ../../home/?home");
        exit();
    }
} else {
    // If the user is not logged in, just redirect to home
    header("Location: ../../home/?home");
    exit();
}
?>
