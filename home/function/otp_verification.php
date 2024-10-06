<?php
session_start(); // Always ensure session is started

if (isset($_POST["verify_otp"])) {
    $entered_otp = trim($_POST["otp"]);
    $stored_otp = $_SESSION["otp"] ?? null; // OTP stored in session, use null if not set
    $otp_expiration = $_SESSION["otp_expiration"] ?? 0; // OTP expiration time, default to 0

    // Verify if the OTP is correct and not expired
    if ($entered_otp == $stored_otp && time() <= $otp_expiration) {
        // OTP is correct, the user can be considered verified
        // All necessary session variables were set in the login process
        
        // Redirect to the admin dashboard (or the appropriate page)
        if ($_SESSION['user_type'] == 'admin') {
            header("Location: ../../admin/?dashboard");
            exit();
        } elseif ($_SESSION['user_type'] == 'agent') {
            header("Location: ../agent/?dashboard");
            exit();
        } else {
            header("Location: ../?home"); // Default redirection
            exit();
        }
    } else {
        // OTP is invalid or expired
        $_SESSION["notify"] = "otp_invalid"; // Notify that OTP is invalid or expired
        header("Location: otp_verification.php");
        exit();
    }
}
?>

<!-- HTML form for OTP verification -->
<form action="otp_verification.php" method="post">
    <input type="text" name="otp" placeholder="Enter OTP" required>
    <button type="submit" name="verify_otp">Verify OTP</button>
</form>
