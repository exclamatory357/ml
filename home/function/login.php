<?php
// Start session and enforce secure session settings
session_start();

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

include "../../config/db.php";

if (isset($_POST["btnlogin"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];  // Direct plain text password comparison

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
        $get_password = $res["pass"];  // Plain text password stored in the database
        $get_user_type = $res["user_type_name"];
        $type_id = $res["user_type_id"];

        // Direct comparison of plain text passwords
        if ($password === $get_password) {

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
            $_SESSION["notify"] = "invalid"; // Invalid password
            header("Location: ../?home");
        }
    } else {
        $_SESSION["notify"] = "invalid"; // User not found
        header("Location: ../?home");
    }
}
?>
