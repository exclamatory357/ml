<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Include database connection
include "../../config/db.php";

// Function to verify reCAPTCHA token
function verify_recaptcha($token) {
    $secretKey = "6Lfn3lAqAAAAAEmcAC4hsbGLGiNiUP79fHwLmYcM";  // Replace with your actual reCAPTCHA secret key
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $token);
    $responseKeys = json_decode($response, true);
    
    return isset($responseKeys['success']) && $responseKeys['success'];
}

// Check if form is submitted
if (isset($_POST["btn-forgot-password"])) {
    // First, verify the reCAPTCHA token
    if (isset($_POST['recaptcha_token'])) {
        $recaptcha_token = $_POST['recaptcha_token'];
        $is_recaptcha_valid = verify_recaptcha($recaptcha_token);

        if (!$is_recaptcha_valid) {
            echo "reCAPTCHA verification failed. Please try again.";
            exit(); // Stop the password reset process
        }
    } else {
        echo "reCAPTCHA token is missing.";
        exit(); // Stop the password reset process
    }

    // Proceed with password reset logic after reCAPTCHA validation
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit();
    }
    
    // Check if the email exists in the database
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Send the reset email (this is just an example; implement the actual sending)
        echo "Password reset instructions have been sent to your email.";
        // Here, implement the logic to send the actual email to the user
    } else {
        echo "No user found with this email.";
    }
}
?>
