<?php
session_start();

// Check if the user is logged in and if they have an admin or superadmin role
if (!isset($_SESSION["username"]) || !isset($_SESSION["role"]) || ($_SESSION["role"] !== "admin" && $_SESSION["role"] !== "superadmin")) {
    // Redirect to login page if not logged in or not an admin
    header("location: ../?home");
    exit(); // Prevent further execution if access is denied
}
?>
