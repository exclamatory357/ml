<?php
session_start();    // Start the session
session_unset();    // Unset session variables for this specific session
session_destroy();  // Destroy the session data for this specific session

// If you want to clear the session cookie as well (session id):
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, 
        $params["path"], $params["domain"], 
        $params["secure"], $params["httponly"]);
}

header("Location: ../../home/?home");  // Redirect to home
exit();             // Ensure no further code is executed
?>
