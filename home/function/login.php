<?php
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
