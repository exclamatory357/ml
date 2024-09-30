<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recaptcha_secret = '6Lfo3lAqAAAAAOzQCiJ8EJN_GSx2m2eD1oPfV4uN';
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // Make request to Google reCAPTCHA API
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $recaptcha_response);
    $responseKeys = json_decode($response, true);

    // Check if reCAPTCHA was successful
    if (intval($responseKeys["success"]) !== 1) {
        echo 'Please complete the CAPTCHA';
    } else {
        // Process form here
        echo 'CAPTCHA verified successfully!';
    }
}
?>
