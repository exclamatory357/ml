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

<!-- HTML for OTP Verification Form with Enhanced UI Design -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRFAMS - OTP Verification</title>
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
        }
        .otp-container .resend-link:hover {
            color: #0056b3;
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
            <a href="resend_otp.php" class="resend-link">Resend OTP</a>
        </form>
    </div>

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
