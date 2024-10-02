<?php
session_start();

if (isset($_POST["verify_otp"])) {
    $entered_otp = trim($_POST["otp"]); // OTP entered by the user
    $stored_otp = $_SESSION["otp"]; // OTP stored in session
    $otp_expiration = $_SESSION["otp_expiration"]; // OTP expiration time

    // Check if OTP is correct and not expired
    if ($entered_otp == $stored_otp && time() <= $otp_expiration) {
        // OTP is correct and not expired, log the user in
        $user_type = $_SESSION["user_type"];
        
        // Redirect the user based on their role
        if ($user_type == 'admin') {
            header("Location: ../../admin/?dashboard");
            exit();
        } elseif ($user_type == 'agent') {
            header("Location: ../agent/?dashboard");
            exit();
        } else {
            header("Location: ../?home");
            exit();
        }
    } else {
        // OTP is incorrect or expired
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
