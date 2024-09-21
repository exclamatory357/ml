<?php
// Start the session (this must be at the top of the file)
session_start();

// Check if the user is not logged in
if (!isset($_SESSION["username"])) {
    // Redirect to home or login page if not authenticated
    header("location: ../?home");
    exit(); // Ensure script stops executing after the redirect
}

// Optional: If you want to restrict based on roles (e.g., only allow admins)
if (isset($_SESSION["role"]) && $_SESSION["role"] !== 'admin') {
    // If the user is not an admin, redirect them (adjust path as needed)
    header("location: ../?home.php");
    exit();
}
