<?php
session_start(); // Always start session at the top of the file

if (isset($_POST["verify_otp"])) {
    // Sanitize the OTP input to remove any malicious code
    $entered_otp = trim(filter_var($_POST["otp"], FILTER_SANITIZE_NUMBER_INT));
    $stored_otp = $_SESSION["otp"] ?? null; // OTP stored in session, default to null if not set
    $otp_expiration = $_SESSION["otp_expiration"] ?? 0; // OTP expiration time, default to 0

    // Verify if the OTP is correct and not expired
    if ($entered_otp === $stored_otp && time() <= $otp_expiration) {
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="width: 24rem;">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">OTP Verification</h3>
                <p class="text-muted text-center mb-4">Enter the OTP code sent to your email to proceed.</p>
                <form action="otp_verification.php" method="post" onsubmit="return validateForm()">
                    <div class="mb-3">
                        <label for="otp" class="form-label">One-Time Password (OTP)</label>
                        <input type="text" name="otp" id="otp" class="form-control" placeholder="Enter OTP" required autofocus minlength="6" maxlength="6" pattern="\d{6}" title="Please enter a 6-digit OTP code">
                    </div>
                    <button type="submit" name="verify_otp" class="btn btn-primary w-100">Verify OTP</button>
                    <div class="text-center mt-3">
                        <a href="resend_otp.php" class="text-decoration-none">Resend OTP</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JavaScript Bundle (including Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Client-side form validation -->
    <script>
        function validateForm() {
            const otpInput = document.getElementById("otp");
            const otpValue = otpInput.value;

            // Ensure OTP is a 6-digit number
            if (!/^\d{6}$/.test(otpValue)) {
                alert("Please enter a valid 6-digit OTP.");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
