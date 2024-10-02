<?php
session_start();
if (isset($_POST["verify_otp"])) {
    $entered_otp = trim($_POST["otp"]);
    $stored_otp = $_SESSION["otp"];
    $otp_expiration = $_SESSION["otp_expiration"];

    // Check if OTP is correct and not expired
    if ($entered_otp == $stored_otp && time() <= $otp_expiration) {
        // OTP is valid, proceed with login
        $user_id = $_SESSION["user_id"];
        $user_type = $_SESSION["user_type"];

        // Redirect based on user role
        switch ($user_type) {
            case "admin":
            case "staff":
                header("Location: ../../admin/?dashboard");
                break;
            case "agent":
                header("Location: ../?request");
                break;
            default:
                header("Location: ../?home");
                break;
        }
    } else {
        $_SESSION["notify"] = "invalid_otp"; // Invalid or expired OTP
        header("Location: otp_verification.php");
        exit();
    }
}
?>

<!-- OTP Verification Form -->
<form action="otp_verification.php" method="post">
    <input type="text" name="otp" placeholder="Enter OTP" required>
    <button type="submit" name="verify_otp">Verify OTP</button>
</form>
