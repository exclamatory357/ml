<?php
// Start session securely
session_start();
ob_start(); // Start output buffering

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

// Verify reCAPTCHA token
function verify_recaptcha($token) {
    $secretKey = "6Lfn3lAqAAAAAEmcAC4hsbGLGiNiUP79fHwLmYcM";  // Replace with your actual reCAPTCHA secret key
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $token);
    $responseKeys = json_decode($response, true);

    if (isset($responseKeys['success']) && $responseKeys['success']) {
        return true;
    } else {
        echo "reCAPTCHA failed: " . json_encode($responseKeys);
        return false;
    }
}

// Check if login button is pressed
if (isset($_POST["btnlogin"])) {
    echo "Login button clicked<br>";

    // Check for reCAPTCHA token
    if (isset($_POST['recaptcha_token'])) {
        echo "reCAPTCHA token found<br>";
        
        $recaptcha_token = $_POST['recaptcha_token'];
        $is_recaptcha_valid = verify_recaptcha($recaptcha_token);
        
        if (!$is_recaptcha_valid) {
            echo "reCAPTCHA validation failed<br>";
            $_SESSION["notify"] = "recaptcha_failed";
            header("Location: ../?home");
            exit();
        }
    } else {
        echo "No reCAPTCHA token found<br>";
        $_SESSION["notify"] = "recaptcha_missing";
        header("Location: ../?home");
        exit();
    }

    // Continue with the login logic after reCAPTCHA is validated
    echo "Proceeding with login logic<br>";
    $username = trim(filter_var($_POST["username"], FILTER_SANITIZE_STRING));
    $password = $_POST["password"];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT user.user_id, user.uname, user.pass, user_type.user_type_name, user_type.user_type_id 
            FROM user 
            INNER JOIN user_type ON user.user_type_id = user_type.user_type_id 
            WHERE uname = ?";
    $stmt = $con->prepare($sql);
    
    if (!$stmt) {
        echo "SQL Error: " . $con->error;
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "User found<br>";
        $res = $result->fetch_assoc();
        $get_user_id = $res["user_id"];
        $get_username = $res["uname"];
        $get_password_hash = $res["pass"]; // Hashed password from the database
        $get_user_type = $res["user_type_name"];
        $type_id = $res["user_type_id"];

        // Verify the password using password_verify()
        if (password_verify($password, $get_password_hash)) {
            echo "Password verified<br>";
            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            // Set session variables based on user role
            $_SESSION["username"] = $get_username;
            $_SESSION["user_id"] = $get_user_id;
            $_SESSION["role"] = $get_user_type;
            $_SESSION["type_id"] = $type_id;

            // Redirect based on user role
            switch ($get_user_type) {
                case "admin":
                case "staff":
                    $_SESSION["admin_uname"] = $get_username; // For backward compatibility
                    header("Location: ../../admin/?dashboard");
                    break;

                case "superadmin":
                    echo "Welcome superadmin<br>";
                    break;

                case "agent":
                    $_SESSION["trans_no"] = rand(); // Example of agent-specific data
                    header("Location: ../?request");
                    break;

                default:
                    header("Location: ../?home");
                    break;
            }
        } else {
            echo "Invalid password<br>";
            $_SESSION["notify"] = "invalid";
            header("Location: ../?home");
            exit();
        }
    } else {
        echo "User not found<br>";
        $_SESSION["notify"] = "invalid";
        header("Location: ../?home");
        exit();
    }
}

ob_end_flush();
?>
