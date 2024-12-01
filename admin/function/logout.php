<?php
session_start();
$user_id = $_SESSION['user_id'];
$session_file = "../../sessions/{$user_id}.txt";

// Invalidate all sessions for the user
if (file_exists($session_file)) {
    unlink($session_file); // Delete the session file
}

session_destroy(); // Destroy the current session
header("Location: ../../home/?home");
exit();
?>
