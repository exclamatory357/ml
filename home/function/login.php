<?php
// Start session securely
session_start();

// Redirect all HTTP requests to HTTPS if not already using HTTPS
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

// Enforce HTTPS with HSTS
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

// Secure session cookie settings
ini_set('session.cookie_secure', '1');    // Enforces HTTPS-only session cookies
ini_set('session.cookie_httponly', '1');  // Prevents JavaScript from accessing session cookies
ini_set('session.cookie_samesite', 'Strict'); // Prevents CSRF by limiting cross-site cookie usage

// Additional security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");

include "../../config/db.php";

if (isset($_POST["btnlogin"])) {
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
            $mail->Subject = 'Your OTP for Login';
            $mail->Body = "Your OTP code is: $otp";

            if (!$mail->send()) {
                $_SESSION["notify"] = "otp_failed"; // Notify OTP email send failure
                header("Location: ../?home");
                exit();
            }

            // Redirect to OTP verification page
            header("Location: otp_verification.php");
            exit();
        } else {
            $_SESSION["notify"] = "invalid"; // Invalid password
            header("Location: ../?home");
            exit();
        }
    } else {
        $_SESSION["notify"] = "invalid"; // User not found
        header("Location: ../?home");
        exit();
    }
}
?>
