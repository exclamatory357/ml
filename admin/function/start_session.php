<?php
session_start();
$session_token = bin2hex(random_bytes(32)); // Generate a unique token
$_SESSION['session_token'] = $session_token;
$user_id = $_SESSION['user_id']; // Use user_id

// Store session token in a file
$session_file = "../../sessions/{$user_id}.txt";
file_put_contents($session_file, $session_token . "\n", FILE_APPEND);
?>
