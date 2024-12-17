<?php
// reCAPTCHA secret key from Google
$secretKey = '6LdDXo8qAAAAAGqXCz1aWC3sRbxwc-ZTU8wfW2D-';

// Get POST data from AJAX request
$postData = file_get_contents('php://input');
$request = json_decode($postData, true);
$recaptchaResponse = $request['recaptcha_response'];

// Verify reCAPTCHA token
$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = [
    'secret' => $secretKey,
    'response' => $recaptchaResponse,
    'remoteip' => $_SERVER['REMOTE_ADDR']
];

$options = [
    'http' => [
        'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);
$result = json_decode($response, true);

// Return the verification result to the client
echo json_encode($result);
?>
