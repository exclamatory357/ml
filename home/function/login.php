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
    $sql = "SELECT user.user_id, user.uname, user.pass, user_type.user_type_name, user_type.user_type_id, user.email, user.reset_token 
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
        $reset_token = $res["reset_token"];

        // Check if the user is already logged in (using reset_token as an indicator)
        if ($reset_token !== NULL && $reset_token !== '') {
            $_SESSION["notify"] = "locked";
            header("Location: ../?home");
            exit();
        }

        if (password_verify($password, $get_password_hash)) {
            session_regenerate_id(true);

            // Reset login attempts on successful login
            $_SESSION['login_attempts'] = 0;
            unset($_SESSION['timeout']);

            $_SESSION["user_id"] = $res["user_id"];
            $_SESSION["username"] = $res["uname"];
            $_SESSION["role"] = $res["user_type_name"];
            $_SESSION["type_id"] = $res["user_type_id"];

            // Set reset_token to indicate that the user has logged in
            $new_reset_token = bin2hex(random_bytes(32)); // Generate a new unique token
            $update_token_sql = "UPDATE user SET reset_token = ? WHERE user_id = ?";
            $stmt_update = $con->prepare($update_token_sql);
            $stmt_update->bind_param("si", $new_reset_token, $res["user_id"]);
            $stmt_update->execute();

            // OTP generation and sending via Infobip SMS
            $otp = rand(100000, 999999);
            $_SESSION["otp"] = $otp;
            $_SESSION["otp_expiration"] = time() + 300;

            // Infobip API Credentials
            $api_url = "https://rpyrel.api.infobip.com/sms/2/text/advanced"; // Infobip API URL
            $api_key = "0a832d8a4db4828fb3335a7528562633-d9e70d4b-bbce-41a4-bbc1-20764119b392"; // Infobip API Key
            $sender = "DRFAMS"; // Replace with your Infobip Sender ID (e.g., your brand name or short code)

            // Static phone number (e.g., +1234567890)
            $to = "+639702638825"; // Static phone number to receive OTP
            $message = "Your OTP for login is: $otp"; // OTP message content

            // Prepare data for the request
            $data = array(
                "messages" => array(
                    array(
                        "destinations" => array(
                            array(
                                "to" => $to
                            )
                        ),
                        "from" => $sender,
                        "text" => $message
                    )
                )
            );

            // Convert data to JSON format
            $data_json = json_encode($data);

            // Set headers for the request
            $headers = array(
                "Authorization: App $api_key",  // Add the API key in the Authorization header
                "Content-Type: application/json",  // Specify content type as JSON
            );

            // Initialize cURL session
            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);

            // Execute the cURL request and capture the response
            $response = curl_exec($ch);

            // Close the cURL session
            curl_close($ch);

            // Check if the SMS was sent successfully
            if ($response === false) {
                $_SESSION["notify"] = "otp_failed";
                header("Location: ../?home");
                exit();
            }

            header("Location: otp_verification.php");
            exit();
        } else {
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
