<?php
session_start(); // Always start session at the top of the file

// Add a limit for OTP verification attempts
$otp_attempt_limit = 3;
$_SESSION["otp_attempts"] = $_SESSION["otp_attempts"] ?? 0;

if (isset($_POST["verify_otp"])) {
    $entered_otp = trim($_POST["otp"]);
    $stored_otp = $_SESSION["otp"] ?? null; // OTP stored in session, default to null if not set
    $otp_expiration = $_SESSION["otp_expiration"] ?? 0; // OTP expiration time, default to 0

    // Verify if the OTP is correct and not expired
    if ($entered_otp == $stored_otp && time() <= $otp_expiration) {
        // OTP is correct, reset the attempt count
        $_SESSION["otp_attempts"] = 0;
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
        // OTP is incorrect or expired
        $_SESSION["otp_attempts"] += 1;

        if ($_SESSION["otp_attempts"] >= $otp_attempt_limit) {
            // Too many attempts, destroy the session
            session_destroy();
            header("Location: ../?home");
            exit();
        }

        $_SESSION["notify"] = "otp_invalid"; // Notify user that OTP is invalid or expired
        header("Location: otp_verification.php"); // Redirect back to OTP page
        exit();
    }
}
?>

<!-- HTML for OTP Verification Form with Enhanced UI Design and SweetAlert2 -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRFAMS - OTP Verification</title>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('danrose_house2.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .otp-container {
            background-color: rgba(255, 255, 255, 0.85);
            padding: 2.5em;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 320px;
            text-align: center;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }

        .otp-container:hover {
            transform: translateY(-5px);
        }

        .otp-container h2 {
            color: #333;
            margin-bottom: 1.2em;
            font-size: 1.5em;
        }

        .otp-container p {
            font-size: 0.95em;
            margin-bottom: 1.8em;
            color: #555;
        }

        .otp-container form {
            display: flex;
            flex-direction: column;
        }

        .otp-container label {
            margin-bottom: 0.5em;
            font-weight: 600;
            text-align: left;
            font-size: 0.9em;
            color: #555;
        }

        .otp-container input[type="text"],
        .otp-container button {
            padding: 0.85em;
            border-radius: 6px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 1.2em;
        }

        .otp-container input[type="text"] {
            border: 1px solid #ddd;
            font-size: 0.95em;
            transition: border-color 0.3s;
        }

        .otp-container input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
        }

        .otp-container button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .otp-container button:hover {
            background-color: #0056b3;
        }

        .otp-container .resend-link {
            font-size: 0.9em;
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s;
            cursor: pointer;
        }

        .otp-container .resend-link.disabled {
            color: #999;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <div class="otp-container">
        <h2>OTP Verification</h2>
        <p>DanRose Fishing Management System</p>
        <form action="otp_verification.php" method="post" onsubmit="return validateForm()">
            <label for="otp">One-Time Password (OTP):</label>
            <input type="text" name="otp" id="otp" placeholder="Enter OTP" required minlength="6" maxlength="6" pattern="\d{6}" title="Please enter a 6-digit OTP code">
            <button type="submit" name="verify_otp">Verify OTP</button>
            <a id="resendLink" href="resend_otp.php" class="resend-link disabled">Resend OTP (Wait 60s)</a>
        </form>
    </div>

    <!-- SweetAlert2 Notifications -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            <?php if (isset($_SESSION["notify"])): ?>
                <?php if ($_SESSION["notify"] == "otp_resend_success"): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'OTP Sent',
                        text: 'A new OTP has been sent to your email.',
                        confirmButtonColor: '#007bff'
                    });
                <?php elseif ($_SESSION["notify"] == "otp_resend_failed"): ?>
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to Send OTP',
                        text: 'Unable to send OTP. Please try again later.',
                        confirmButtonColor: '#007bff'
                    });
                <?php elseif ($_SESSION["notify"] == "otp_invalid"): ?>
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid OTP',
                        text: 'The OTP you entered is invalid or has expired.',
                        confirmButtonColor: '#007bff'
                    });
                <?php endif; ?>
                <?php unset($_SESSION["notify"]); ?>
            <?php endif; ?>

            // Timer for Resend OTP link
            let resendLink = document.getElementById("resendLink");
            let countdown = 60;

            const timer = setInterval(function () {
                countdown--;
                resendLink.innerText = `Resend OTP (Wait ${countdown}s)`;

                if (countdown <= 0) {
                    clearInterval(timer);
                    resendLink.classList.remove("disabled");
                    resendLink.innerText = "Resend OTP";
                    resendLink.style.pointerEvents = "auto";
                }
            }, 1000);
        });

        function validateForm() {
            const otpInput = document.getElementById("otp");
            const otpValue = otpInput.value;

            // Ensure OTP is a 6-digit number
            if (!/^\d{6}$/.test(otpValue)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid OTP',
                    text: 'Please enter a valid 6-digit OTP.',
                    confirmButtonColor: '#007bff'
                });
                return false;
            }
            return true;
        }
    </script>
</body>

</html>