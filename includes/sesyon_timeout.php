<?php
session_start();
$timeout_duration = 1800; // 30 minutes

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/'); // Clear session cookie
    header("Location: ../../home/?home"); // Redirect after timeout
    exit();
}

$_SESSION['last_activity'] = time(); // Update last activity time
?>
