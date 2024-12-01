<?php
// Start the session
session_start();    

// Clear all session variables
session_unset(); 

// Destroy the session
session_destroy();  

// Clear the session cookie (if it exists)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, 
        $params["path"], $params["domain"], 
        $params["secure"], $params["httponly"]
    );
}

// Redirect to the home page (or any page you'd like)
header("Location: ../../home/?home");  
exit();  // Ensure no further code is executed
?>
