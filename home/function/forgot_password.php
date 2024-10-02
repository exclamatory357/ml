<?php

include "../../config/db.php";
// Include PHPMailer classes manually
require 'phpmailer/class.phpmailer.php';
require 'phpmailer/class.smtp.php';

// Check if form is submitted
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Invalid email format
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Invalid Email</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Email Format',
                    text: 'Please enter a valid email address.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    window.location.href = '../?home';
                });
            </script>
        </body>
        </html>
        <?php
        exit;
    }

    // Check if the email exists in the database (case-insensitive)
    $query = "SELECT * FROM user WHERE LOWER(email) = LOWER(?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Generate a unique token for password reset
        $rawToken = bin2hex(random_bytes(50));  // The raw token that will be sent to the user
        $hashedToken = password_hash($rawToken, PASSWORD_DEFAULT);  // Hashed token to store in the database

        // Set token expiry time (e.g., 1 hour from now)
        $expiryTime = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Store hashed token and token expiry in the database
        $query = "UPDATE user SET reset_token = ?, token_expiry = ? WHERE LOWER(email) = LOWER(?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sss", $hashedToken, $expiryTime, $email);
        $stmt->execute();

        // Send reset password email using PHPMailer
        $mail = new PHPMailer();

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'danrosefishing30@gmail.com'; // Your Gmail address
            $mail->Password   = 'meyj axmh socg tivf';  // Your Gmail app-specific password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('danrosefishing30@gmail.com', 'DanRose Fishing Management System');
            $mail->addAddress($email);     // Add a recipient

            // Email Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "
            <html>
            <body>
                <h1>Password Reset Request</h1>
                <p>Click the button below to reset your password:</p>
                <a href='https://danrosefishing.com/home/function/reset_password.php?token=" . urlencode($rawToken) . "&email=" . urlencode($email) . "'>Reset Password</a>
            </body>
            </html>
            ";

            // Send mail
            if ($mail->send()) {
                ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <title>Password Reset</title>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                </head>
                <body>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Password reset link has been sent to your email.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = '../?home';
                        });
                    </script>
                </body>
                </html>
                <?php
            } else {
                ?>
                <script>alert('Mailer Error: <?= $mail->ErrorInfo ?>');</script>
                <?php
            }
        } catch (Exception $e) {
            ?>
            <script>alert('Mailer Error: <?= $mail->ErrorInfo ?>');</script>
            <?php
        }
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Error</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No user found with that email.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '../?home';
                });
            </script>
        </body>
        </html>
        <?php
    }

    $stmt->close();
    $con->close();
}
?>
