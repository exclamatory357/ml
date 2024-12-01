<?php
session_start();    // Start the session
session_destroy();  // Destroy the session data
header("Location: ../../home/?home");  // Redirect to home
exit();             // Ensure no further code is executed
?>
