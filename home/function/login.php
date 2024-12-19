<?php
session_start();
include "../../config/db.php";

// Define maximum attempts and lockout duration
$max_attempts = 3;
$lockout_duration = 300; // 5 minutes in seconds

// Include Guzzle
require '../../vendor/autoload.php'; // Adjust the path to your Composer autoload file

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
    $sql = "SELECT user.user_id, user.uname, user.pass, user.contact_no, user_type.user_type_name, 
            user_type.user_type_id, user.reset_token 
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
        $contact_no = $res["contact_no"];

        // Check if the user is already logged in (using reset_token as an indicator)
        if ($reset_token !== NULL && $reset_token !== '') {
            $_SESSION["notify"] = "locked";
            header("Location: ../?home");
            exit();
        }

        // Verify password
        if (password_verify($password, $get_password_hash)) {
            session_regenerate_id(true); // Prevent session fixation

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

            // OTP generation
            $otp = rand(100000, 999999);
            $_SESSION["otp"] = $otp;
            $_SESSION["otp_expiration"] = time() + 300;

            // Send OTP via Infobip SMS API using Guzzle (HTTP/2)
            $api_url = "https://rpyrel.api.infobip.com/sms/2/text/advanced";
            $api_key = "0a832d8a4db4828fb3335a7528562633-d9e70d4b-bbce-41a4-bbc1-20764119b392";
            $sender = "unknown"; // Adjust the sender name if needed

            // Prepare message data for Infobip
            $sms_data = [
                "messages" => [
                    [
                        "from" => $sender,
                        "to" => $contact_no,
                        "text" => "Your OTP for login is: $otp"
                    ]
                ]
            ];

            try {
                // Initialize Guzzle HTTP client
                $client = new GuzzleHttp\Client([
                    'base_uri' => $api_url,
                    'http_version' => '2.0',  // Enable HTTP/2
                    'headers' => [
                        'Authorization' => 'App ' . $api_key,
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ]
                ]);

                // Send the request
                $response = $client->post('', [
                    'json' => $sms_data
                ]);

                // Check the response status
                if ($response->getStatusCode() === 200) {
                    // Proceed to OTP verification page
                    header("Location: otp_verification.php");
                    exit();
                } else {
                    $_SESSION["notify"] = "otp_failed";
                    header("Location: ../?home");
                    exit();
                }
            } catch (Exception $e) {
                error_log($e->getMessage()); // Log the error message for debugging
                $_SESSION["notify"] = "otp_failed";
                header("Location: ../?home");
                exit();
            }
            

        } else {
            // Increment login attempts on failed login
            $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] + 1 : 1;

            // Lock the user out after reaching maximum attempts
            if ($_SESSION['login_attempts'] >= $max_attempts) {
                $_SESSION['timeout'] = time() + $lockout_duration;
            }

            $_SESSION["notify"] = "invalid";
            header("Location: ../?home");
            exit();
        }
    } else {
        // Invalid username
        $_SESSION["notify"] = "invalid";
        $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] + 1 : 1;

        // Lock the user out after reaching maximum attempts
        if ($_SESSION['login_attempts'] >= $max_attempts) {
            $_SESSION['timeout'] = time() + $lockout_duration;
        }

        header("Location: ../?home");
        exit();
    }
}
?>
