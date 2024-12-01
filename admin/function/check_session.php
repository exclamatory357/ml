<?php
session_start();
$user_id = $_SESSION['user_id'];
$session_token = $_SESSION['session_token'];
$session_file = "../../sessions/{$user_id}.txt";

if (!file_exists($session_file)) {
    // Session file does not exist, redirect to login
    session_destroy();
    header("Location: ../../home/?home");
    exit();
}

$tokens = file($session_file, FILE_IGNORE_NEW_LINES);
if (!in_array($session_token, $tokens)) {
    // Session token is not valid
    session_destroy();
    header("Location: ../../home/?home");
    exit();
}
?>
