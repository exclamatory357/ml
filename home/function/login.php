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

// Set login attempt limits and timeout
$login_attempt_limit = 3;
$timeout_duration = 300; // 5 minutes (in seconds)

// Initialize login attempts if not set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

// Check if timeout is active
if (isset($_SESSION['timeout']) && time() < $_SESSION['timeout']) {
    $_SESSION['notify'] = "login_disabled"; // Notify that the login is disabled
    header("Location: ../?home");
    exit();
}

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
    $sql = "SELECT user.user_id, user.uname, user.pass, user_type.user_type_name, user_type.user_type_id 
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

        // Verify the password using password_verify()
        if (password_verify($password, $get_password_hash)) {

            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            // Reset login attempts on successful login
            $_SESSION['login_attempts'] = 0;
            unset($_SESSION['timeout']);

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
                    header("Location: ../../admin/?dashboard"); // Redirect to admin side
                    break;

                case "superadmin":
                    echo "Welcome superadmin";
                    break;

                case "agent":
                    $_SESSION["trans_no"] = rand(); // Example of agent-specific data
                    header("Location: ../?request"); // Redirect to agent reservation page
                    break;

                default:
                    header("Location: ../?home"); // Default fallback if role is not recognized
                    break;
            }
        } else {
            // Password is incorrect, increment login attempts
            $_SESSION['login_attempts'] += 1;

            // If login attempts exceed limit, set a timeout
            if ($_SESSION['login_attempts'] >= $login_attempt_limit) {
                $_SESSION['timeout'] = time() + $timeout_duration; // Set the timeout
                $_SESSION["notify"] = "login_disabled"; // Notify the user
            } else {
                $_SESSION["notify"] = "invalid"; // Invalid password
            }

            header("Location: ../?home");
            exit();
        }
    } else {
        // User not found, increment login attempts
        $_SESSION['login_attempts'] += 1;

        // If login attempts exceed limit, set a timeout
        if ($_SESSION['login_attempts'] >= $login_attempt_limit) {
            $_SESSION['timeout'] = time() + $timeout_duration;
            $_SESSION["notify"] = "login_disabled"; // Notify the user
        } else {
            $_SESSION["notify"] = "invalid"; // Invalid credentials
        }

        header("Location: ../?home");
        exit();
    }
}
?>
