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
    $mail->isHTML(true);  // Set email format to HTML
    $mail->Subject = 'Your OTP for Login';
    
    $mail->Body = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                color: #333;
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100%;
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .header {
                background-color: #007bff;
                color: #ffffff;
                text-align: center;
                padding: 20px;
                font-size: 24px;
                font-weight: bold;
            }
            .content {
                padding: 20px;
                text-align: center;
            }
            .otp-code {
                font-size: 32px;
                font-weight: bold;
                color: #007bff;
                margin: 20px 0;
            }
            .footer {
                background-color: #f4f4f4;
                padding: 10px;
                text-align: center;
                font-size: 12px;
                color: #777;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                Your OTP for Login
            </div>
            <div class='content'>
                <p>Hello,</p>
                <p>Your new One-Time Password (OTP) code is:</p>
                <div class='otp-code'>$otp</div>
                <p>This code is valid for a limited time only (5 minutes). If you did not request this OTP, please ignore this email.</p>
            </div>
            <div class='footer'>
                © 2024 Your Company. All rights reserved.
            </div>
        </div>
    </body>
    </html>
    ";
    

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
