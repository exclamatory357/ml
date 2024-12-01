<?php
// Set cookie parameters before starting the session
$cookieParams = session_get_cookie_params();

// Ensure the cookie is only sent over secure connections (HTTPS)
$secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'; // Check if the connection is secure

// Set SameSite flag to prevent CSRF (Choose 'Strict' or 'Lax')
$sameSite = 'Strict'; // You can also use 'Lax' or 'None'

// Modify session cookie parameters
session_set_cookie_params([
    'lifetime' => $cookieParams['lifetime'],  // Cookie lifetime (session default)
    'path' => $cookieParams['path'],          // Path where the cookie is valid
    'domain' => $cookieParams['domain'],      // Cookie domain
    'secure' => $secure,                      // Cookie is only sent over HTTPS
    'httponly' => true,                       // Cookie is only accessible via HTTP (not JavaScript)
    'samesite' => $sameSite                   // SameSite cookie behavior
]);

session_start();  // Start the session

// Now proceed with your session handling
session_unset();    // Unset session variables
session_destroy();  // Destroy the session data

// Remove the session cookie manually if required
setcookie(session_name(), '', time() - 42000, $cookieParams["path"], $cookieParams["domain"], $secure, true);

header("Location: ../../home/?home");  // Redirect to home
exit();  // Ensure no further code is executed
?>
