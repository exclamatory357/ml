<?php
session_start();
include "../../config/db.php";

// Define maximum attempts and lockout duration
$max_attempts = 3;
$lockout_duration = 300; // 5 minutes in seconds

if (isset($_POST["btnlogin"])) {
    // Check if the user is locked out
    if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= $max_attempts) {
        $remaining_time = $_SESSION['timeout'] - time();
        if ($remaining_time > 0) {
            $_SESSION["notify"] = "locked"; // Notify that the user is locked out
            header("Location: ../?home");
            exit();
        } else {
            // Reset login attempts after lockout period
            $_SESSION['login_attempts'] = 0;
            unset($_SESSION['timeout']);
        }
    }

    // Sanitize and validate inputs
    $username = trim(filter_var($_POST["username"], FILTER_SANITIZE_STRING));
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $_SESSION["notify"] = "invalid";
        header("Location: ../?home");
        exit();
    }

    // Prepared statement to prevent SQL injection
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
        $get_password_hash = $res["pass"];

        if (password_verify($password, $get_password_hash)) {
            session_regenerate_id(true);

            // Reset login attempts on successful login
            $_SESSION['login_attempts'] = 0;
            unset($_SESSION['timeout']);

            // OTP generation and sending via PHPMailer
            $otp = rand(100000, 999999);
            $_SESSION["otp"] = $otp;
            $_SESSION["otp_expiration"] = time() + 300;

            $_SESSION["user_id"] = $res["user_id"];
            $_SESSION["username"] = $res["uname"];
            $_SESSION["role"] = $res["user_type_name"];
            $_SESSION["type_id"] = $res["user_type_id"];

            // Update login status to 1 (logged in)
            $update_status_sql = "UPDATE user SET reset_token = 1 WHERE user_id = ?";
            $status_stmt = $con->prepare($update_status_sql);
            $status_stmt->bind_param("i", $res["user_id"]);
            $status_stmt->execute();

            // Set up PHPMailer to send OTP
            require 'phpmailer/PHPMailerAutoload.php';
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'danrosefishing30@gmail.com';
            $mail->Password = 'meyj axmh socg tivf';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('noreply-danrosefishing30@gmail.com', 'Danrose Fishing Management System');
            $mail->addAddress($res["email"]);
            $mail->isHTML(true);
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
                $_SESSION["notify"] = "otp_failed";
                header("Location: ../?home");
                exit();
            }

            header("Location: otp_verification.php");
            exit();
        } else {
            // Increment login attempts on invalid password
            $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] + 1 : 1;

            if ($_SESSION['login_attempts'] >= $max_attempts) {
                $_SESSION['timeout'] = time() + $lockout_duration;
            }

            $_SESSION["notify"] = "invalid";
            header("Location: ../?home");
            exit();
        }
    } else {
        $_SESSION["notify"] = "invalid";
        $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] + 1 : 1;

        if ($_SESSION['login_attempts'] >= $max_attempts) {
            $_SESSION['timeout'] = time() + $lockout_duration;
        }

        header("Location: ../?home");
        exit();
    }
}
?>
