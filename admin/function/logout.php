<?php
session_start();  // Start the session

// Ensure that the session ID is unset across all devices and browsers by clearing the session cookie
$cookieParams = session_get_cookie_params(); // Get current session cookie parameters
setcookie(session_name(), '', time() - 42000, $cookieParams['path'], $cookieParams['domain'], $cookieParams['secure'], $cookieParams['httponly']); // Clear the session cookie

// Destroy the session data and unset session variables
session_unset();    // Unset all session variables
session_destroy();  // Destroy the session itself

// Redirect to the home page
header("Location: ../../home/?home");  // Redirect to home
exit();  // Ensure no further code is executed
?>
