<?php
// Start session securely
session_start();

// Uncomment and configure these settings in a production environment
/*
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
ini_set('session.cookie_secure', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Strict');
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
*/

include "../../config/db.php";

// Define maximum allowed attempts and lockout duration
define('MAX_LOGIN_ATTEMPTS', 3);
define('LOCKOUT_DURATION', 300); // 5 minutes in seconds

if (isset($_POST["btnlogin"])) {
    // Check if the user is currently locked out
    if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= MAX_LOGIN_ATTEMPTS) {
        $remaining_time = $_SESSION['timeout'] - time();
        if ($remaining_time > 0) {
            $_SESSION["notify"] = "locked_out"; // Notify user they are locked out
            header("Location: ../?home");
            exit();
        } else {
            // Lockout period has expired; reset attempts
            $_SESSION['login_attempts'] = 0;
            unset($_SESSION['timeout']);
        }
    }

    // Sanitize and validate inputs
    $username = trim(filter_var($_POST["username"], FILTER_SANITIZE_STRING));
    $password = $_POST["password"]; // Password entered by the user

    // Check for empty inputs (basic validation)
    if (empty($username) || empty($password)) {
        $_SESSION["notify"] = "invalid"; // Empty credentials
        header("Location: ../?home");
        exit();
    }

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT user.user_id, user.uname, user.pass, user_type.user_type_name, user_type.user_type_id, user.email 
            FROM user 
            INNER JOIN user_type ON user.user_type_id = user_type.user_type_id 
            WHERE uname = ?";
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        // Handle SQL preparation error
        $_SESSION["notify"] = "server_error";
        header("Location: ../?home");
        exit();
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $res = $result->fetch_assoc();
        $get_user_id = $res["user_id"];
        $get_username = $res["uname"];
        $get_password_hash = $res["pass"]; // Hashed password from the database
        $get_user_type = $res["user_type_name"];
        $type_id = $res["user_type_id"];
        $email = $res["email"]; // User's email for sending OTP

        // Verify the password using password_verify()
        if (password_verify($password, $get_password_hash)) {
            // Successful login

            // Reset login attempts
            $_SESSION['login_attempts'] = 0;
            unset($_SESSION['timeout']);

            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            // Generate OTP and store it in session
            $otp = rand(100000, 999999); // Generate a 6-digit OTP
            $_SESSION["otp"] = $otp; // Store OTP in session
            $_SESSION["otp_expiration"] = time() + 300; // Set OTP expiration (5 minutes)

            // Store user data for later use
            $_SESSION["user_id"] = $get_user_id;
            $_SESSION["username"] = $get_username;
            $_SESSION["role"] = $get_user_type;
            $_SESSION["type_id"] = $type_id;

            // Send OTP via email (using PHPMailer)
            require 'phpmailer/PHPMailerAutoload.php'; // Make sure PHPMailer is properly configured
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'danrosefishing30@gmail.com'; // Your email address
            $mail->Password = 'meyj axmh socg tivf'; // App-specific password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('noreply-danrosefishing30@gmail.com', 'Danrose Fishing Management System');
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
                        background-color: #AF0401;
                        color: #ffffff;
                        text-align: center;
                        padding: 20px;
                        font-size: 24px;
                    }
                    .content {
                        padding: 20px;
                        text-align: center;
                    }
                    .otp-code {
                        font-size: 32px;
                        font-weight: bold;
                        color: #AF0401;
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
                        <p>Please use the following One-Time Password (OTP) to complete your login:</p>
                        <div class='otp-code'>$otp</div>
                        <p>This OTP is valid for a limited time only (5 minutes). If you did not request this, please ignore this email.</p>
                    </div>
                    <div class='footer'>
                        © 2024 Danrose Fishing Agency Management System. All rights reserved.
                    </div>
                </div>
            </body>
            </html>
            ";

            if (!$mail->send()) {
                $_SESSION["notify"] = "otp_failed"; // Notify OTP email send failure
                header("Location: ../?home");
                exit();
            }

            // Redirect to OTP verification page
            header("Location: otp_verification.php");
            exit();
        } else {
            // Invalid password
            handleFailedLogin();
        }
    } else {
        // User not found
        handleFailedLogin();
    }
} else {
    // If accessed without POST data
    header("Location: ../?home");
    exit();
}

// Function to handle failed login attempts
function handleFailedLogin() {
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 1;
    } else {
        $_SESSION['login_attempts'] += 1;
    }

    if ($_SESSION['login_attempts'] >= MAX_LOGIN_ATTEMPTS) {
        $_SESSION['timeout'] = time() + LOCKOUT_DURATION; // Set lockout timeout
        $_SESSION["notify"] = "locked_out"; // Notify user they are locked out
    } else {
        $_SESSION["notify"] = "invalid"; // Invalid credentials
    }

    header("Location: ../?home");
    exit();
}
?>
