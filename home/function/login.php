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

        
// OTP Generation and Session Handling
$otp = rand(100000, 999999); // Generate a 6-digit OTP
$_SESSION["otp"] = $otp;
$_SESSION["otp_expiration"] = time() + 300; // Set OTP validity for 5 minutes (300 seconds)

// Infobip API Configuration
$infobipUrl = "https://8kzy19.api.infobip.com/sms/2/text/advanced";

$infobipApiKey = "736c23f2e17c91957df713ee3df4b868-bcc4e894-94a1-49b6-85ec-099e707629f3"; // Replace with your Infobip API key

// SMS Details
$recipientPhone = $res["contact_no"];

$message = "Your OTP for Danrose Fishing Management System is $otp. This OTP is valid for 5 minutes.";

$data = [
    "messages" => [
        [
            "from" => "DanRoseFishing", // Sender ID (must be approved in Infobip)
            "destinations" => [
                ["to" => $recipientPhone]
            ],
            "text" => $message
        ]
    ]
];

// Send OTP via Infobip API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $infobipUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: App $infobipApiKey",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Get Response
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Handle Response
if ($httpCode == 200) {
    // Successfully sent OTP
    header("Location: otp_verification.php"); // Redirect to OTP verification page
    exit();
} else {
    // OTP Sending Failed
    $_SESSION["notify"] = "otp_failed";
    header("Location: ../?home"); // Redirect to home page or show error
    exit();
}

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
