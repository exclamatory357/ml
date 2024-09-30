<?php
session_start();
error_reporting(1);
// Redirect to login if not logged in
if (!isset($_SESSION["username"])) {
    header("Location: ../?home");
    exit();
}

// Role-based access control
function checkRole($requiredRole) {
    if (isset($_SESSION["role"]) && $_SESSION["role"] !== $requiredRole) {
        // Redirect to a generic page if the user doesn't have the required role
        header("Location: ../?home");
        exit();
    }
}

// Admin Access
function checkAdmin() {
    checkRole('admin');
}

// Superadmin Access
function checkSuperadmin() {
    checkRole('superadmin');
}

// Agent Access
function checkAgent() {
    checkRole('agent');
}

// Staff Access
function checkStaff() {
    checkRole('staff');
}
?>
