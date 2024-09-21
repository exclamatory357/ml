<?php
// PHP script to limit requests from a single IP address
session_start();
if (!isset($_SESSION['request_count'])) {
    $_SESSION['request_count'] = 0;
}
$_SESSION['request_count']++;

if ($_SESSION['request_count'] > 100) {
    // If the user exceeds 100 requests in the session, block them
    die("Too many requests. Please try again later.");
}

// Redirect all HTTP requests to HTTPS
if ($_SERVER['HTTPS'] !== 'on') {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

// Enforce HTTPS with HSTS
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

// Secure session cookie settings
ini_set('session.cookie_secure', '1');   // Enforces HTTPS-only session cookies
ini_set('session.cookie_httponly', '1'); // Prevents JavaScript from accessing session cookies
ini_set('session.cookie_samesite', 'Strict'); // Prevents CSRF by limiting cross-site cookie usage

session_start();

// PHP script to limit requests from a single IP address
if (!isset($_SESSION['request_count'])) {
    $_SESSION['request_count'] = 0;
}
$_SESSION['request_count']++;

if ($_SESSION['request_count'] > 100) {
    die("Too many requests. Please try again later.");
}

// Account lockout mechanism
if (!isset($_SESSION['failed_attempts'])) {
    $_SESSION['failed_attempts'] = 0;
}

if ($_SESSION['failed_attempts'] >= 3) {
    die("Account locked due to too many failed login attempts.");
}

include "../../config/db.php";

if (isset($_POST["btnlogin"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM user 
            INNER JOIN user_type ON user.user_type_id = user_type.user_type_id
            WHERE uname = '$username'";
    $query = mysqli_query($con, $sql);

    if (mysqli_num_rows($query) > 0) {
        while ($res = mysqli_fetch_assoc($query)) {
            $get_user_id = $res["user_id"];
            $get_username = $res["uname"];
            $get_password = $res["pass"];
            $get_user_type = $res["user_type_name"];
            $type_id = $res["user_type_id"];
        }

        if ($password === $get_password) {
            if ($get_user_type == "admin") {
                $_SESSION["admin_uname"] = $get_username;
                $_SESSION["type_id"] = $type_id;
                header("location: ../../admin/?dashboard"); // user locate to admin side
            }
            if ($get_user_type == "superadmin") {
                echo "welcome superadmin";
            }
            if ($get_user_type == "agent") {
                $_SESSION["trans_no"] = rand();
                $_SESSION["username"] = $get_username;
                $_SESSION["user_id"] = $get_user_id;
                header("location: ../?request"); // user locate to reservation page
            }
            if ($get_user_type == "staff") {
                $_SESSION["admin_uname"] = $get_username;
                $_SESSION["type_id"] = $type_id;
                header("location: ../../admin/?dashboard"); // user locate to admin side
            }
        } else {
            $_SESSION["notify"] = "invalid";
            header("location: ../?home");
        }
    } else {
        $_SESSION["notify"] = "invalid";
        header("location: ../?home");
    }
}
?>
