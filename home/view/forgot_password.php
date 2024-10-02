<?php
function verify_recaptcha($token) {
    $secretKey = "6Lfn3lAqAAAAAEmcAC4hsbGLGiNiUP79fHwLmYcM";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Lfn3lAqAAAAAEmcAC4hsbGLGiNiUP79fHwLmYcM" . $secretKey . "&response=" . $token);
    $responseKeys = json_decode($response, true);
    return $responseKeys['success'];
}

// In login.php or forgot_password.php
if (isset($_POST['recaptcha_token'])) {
    $recaptcha_token = $_POST['recaptcha_token'];
    $is_recaptcha_valid = verify_recaptcha($recaptcha_token);

    if ($is_recaptcha_valid) {
        // Proceed with the login or password reset process
    } else {
        // Handle recaptcha failure
        echo "reCAPTCHA verification failed. Please try again.";
    }
}
?>
