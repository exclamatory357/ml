<?php
session_start(); // Always ensure session is started

if (isset($_POST["verify_otp"])) {
    $entered_otp = trim($_POST["otp"]);
    $stored_otp = $_SESSION["otp"]; // OTP stored in session
    $otp_expiration = $_SESSION["otp_expiration"]; // OTP expiration time

    // Verify if the OTP is correct and not expired
    if ($entered_otp == $stored_otp && time() <= $otp_expiration) {
        // OTP is correct, set user session variables
        $_SESSION["user_id"] = $_SESSION["user_id"]; // Ensure user_id is set
        $_SESSION["username"] = $_SESSION["username"]; // Set username
        $_SESSION["user_type"] = $_SESSION["user_type"]; // Set user type (e.g., admin)

        // Redirect to admin dashboard
        header("Location: ../../admin/?dashboard");
        exit();
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
