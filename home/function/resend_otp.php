<?php
session_start(); // Start the session

// Include database connection and PHPMailer
include "../../config/db.php";
require 'phpmailer/PHPMailerAutoload.php'; // Make sure PHPMailer is properly configured

// Check if user session data exists
if (!isset($_SESSION["username"]) || !isset($_SESSION["user_id"]) || !isset($_SESSION["role"])) {
    // If there is no session data, redirect to the login page
    header("Location: ../?home");
    exit();
}

$get_user_id = $_SESSION["user_id"];
$get_username = $_SESSION["username"];
$get_user_type = $_SESSION["role"];

// Fetch user email from the database (you can also store it in session if already retrieved)
$sql = "SELECT email FROM user WHERE user_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $get_user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $res = $result->fetch_assoc();
    $email = $res["email"];

    // Generate a new OTP
    $otp = rand(100000, 999999); // Generate a new 6-digit OTP

    // Store the new OTP in the session
    $_SESSION["otp"] = $otp; // Store OTP in session
    $_SESSION["otp_expiration"] = time() + 300; // Set OTP expiration (5 minutes)

    // Send OTP via email using PHPMailer
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'danrosefishing30@gmail.com'; // Your email address
    $mail->Password = 'meyj axmh socg tivf'; // Your app-specific password or SMTP password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('danrosefishing30@gmail.com', 'DanRose Fishing Management System');
    $mail->addAddress($email); // User's email
    $mail->Subject = 'Your OTP for Login';
    $mail->Body = "Your new OTP code is: $otp";

    // Attempt to send the email
    if (!$mail->send()) {
        $_SESSION["notify"] = "otp_resend_failed"; // Notify OTP email send failure
    } else {
        $_SESSION["notify"] = "otp_resend_success"; // Notify OTP was resent successfully
    }

    // Redirect back to the OTP verification page
    header("Location: otp_verification.php");
    exit();
} else {
    // User not found in the database
    $_SESSION["notify"] = "user_not_found"; // Notify user not found
    header("Location: ../?home");
    exit();
}
?>
