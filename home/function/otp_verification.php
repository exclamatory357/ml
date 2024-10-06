<?php
session_start(); // Always start session at the top of the file

if (isset($_POST["verify_otp"])) {
    $entered_otp = trim($_POST["otp"]);
    $stored_otp = $_SESSION["otp"] ?? null; // OTP stored in session, default to null if not set
    $otp_expiration = $_SESSION["otp_expiration"] ?? 0; // OTP expiration time, default to 0

    // Verify if the OTP is correct and not expired
    if ($entered_otp == $stored_otp && time() <= $otp_expiration) {
        // OTP is correct, mark the user as authenticated
        $_SESSION["authenticated"] = true;

        // Redirect based on user role
        $user_type = $_SESSION["role"] ?? '';

        if ($user_type == 'admin' || $user_type == 'staff') {
            header("Location: ../../admin/?dashboard"); // Redirect to admin dashboard
            exit();
        } elseif ($user_type == 'agent') {
            header("Location: ../?request"); // Redirect to agent reservation page
            exit();
        } else {
            header("Location: ../?home"); // Default fallback
            exit();
        }
    } else {
        // OTP is invalid or expired
        $_SESSION["notify"] = "otp_invalid"; // Notify user that OTP is invalid or expired
        header("Location: otp_verification.php"); // Redirect back to OTP page
        exit();
    }
}
?>

<!-- HTML form for OTP verification -->
<form action="otp_verification.php" method="post">
    <input type="text" name="otp" placeholder="Enter OTP" required>
    <button type="submit" name="verify_otp">Verify OTP</button>
</form>
