<?php
session_start();
include "../../config/db.php";

if (isset($_POST["btnlogin"])) {
    $username = trim($_POST["username"]);  // Trim to remove any unwanted spaces
    $password = trim($_POST["password"]);  // Trim to remove any unwanted spaces

    // Check if both username and password are provided
    if (empty($username) || empty($password)) {
        $_SESSION["notify"] = "Please enter both username and password.";
        header("location: ../?home");
        exit();
    }

    // Prepared statement to avoid SQL injection
    $stmt = $con->prepare("SELECT * FROM user 
                           INNER JOIN user_type ON user.user_type_id = user_type.user_type_id
                           WHERE uname = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $res = $result->fetch_assoc();

        $get_user_id = $res["user_id"];
        $get_username = $res["uname"];
        $get_password = $res["pass"]; // Assuming this is a hashed password
        $get_user_type = $res["user_type_name"];
        $type_id = $res["user_type_id"];

        // Verify the hashed password
        if (password_verify($password, $get_password)) {
            // Securely regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            // Based on user type, redirect to the correct dashboard
            if ($get_user_type == "admin" || $get_user_type == "staff") {
                $_SESSION["admin_uname"] = $get_username;
                $_SESSION["type_id"] = $type_id;
                header("location: ../../admin/?dashboard"); // Redirect to admin side
            } elseif ($get_user_type == "superadmin") {
                echo "welcome superadmin";
            } elseif ($get_user_type == "agent") {
                $_SESSION["trans_no"] = rand();
                $_SESSION["username"] = $get_username;
                $_SESSION["user_id"] = $get_user_id;
                header("location: ../?request"); // Redirect to reservation page
            }
        } else {
            $_SESSION["notify"] = "Invalid username or password."; // Incorrect password
            header("location: ../?home");
        }
    } else {
        $_SESSION["notify"] = "Invalid username or password."; // User not found
        header("location: ../?home");
    }

    $stmt->close();
}
?>
