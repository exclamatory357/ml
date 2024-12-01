


<?php
// Include a session management script from the includes folder
include "../../includes/sesyon_timeout.php";
include "../../includes/sesyon_functions.php";
include "../../includes/sesyon_db.php";

session_start();

// Clear session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Clear cookies if they were set for "Remember Me"
if (isset($_COOKIE['uname'])) {
    setcookie('uname', '', time() - 3600, '/');
}
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/');
}

// Redirect to the login page or homepage
header("Location: ../../home/?home");
exit();
?>
