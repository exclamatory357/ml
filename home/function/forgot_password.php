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

    // Check if the email exists in the database
    $query = "SELECT * FROM user WHERE email = ?";
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
        $query = "UPDATE user SET reset_token = ?, token_expiry = ? WHERE email = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sss", $hashedToken, $expiryTime, $email);
        $stmt->execute();

        // Send reset password email using PHPMailer
        $mail = new PHPMailer();

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;
            $mail->Username   = 'danrosefishing30@gmail.com'; // Your Gmail address
            $mail->Password   = 'meyj axmh socg tivf';  // Your Gmail password or app password
            $mail->SMTPSecure = 'tls';  // Encryption: 'tls' or 'ssl'
            $mail->Port       = 587;    // Port for TLS connection

            //Recipients
            $mail->setFrom('danrosefishing30@gmail.com', 'DanRose Fishing Management System');
            $mail->addAddress($email);     // Add a recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "
<!DOCTYPE html>
<html>
<head>
    <style>
        /* General email styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            width: 100%;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-content {
            max-width: 600px;
            background-color: #fff;
            margin: 0 auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .email-header {
            background-color: #007BFF;
            padding: 20px;
            color: #fff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            margin: 20px 0;
            font-size: 16px;
            line-height: 1.6;
        }
        .button {
            background-color: #007BFF;
            color: #ffffff;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .email-footer {
            margin-top: 30px;
            font-size: 12px;
            color: #888888;
        }
        .email-footer a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class='email-container'>
        <div class='email-content'>
            <div class='email-header'>
                <h1>Password Reset Request</h1>
            </div>
            <div class='email-body'>
                <p>Hi,</p>
                <p>We received a request to reset your password. Click the button below to proceed:</p>
                <a href='" . $resetLink . "' class='button'>Reset Password</a>
                <p>If you did not request this, please ignore this email or contact our support.</p>
            </div>
            <div class='email-footer'>
                <p>&copy; " . date('Y') . " DanRose Fishing Management System. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
";


            // Send mail
            if ($mail->send()) {
                // Email sent successfully
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
                        }).then((result) => {
                            window.location.href = '../?home';
                        });
                    </script>
                </body>
                </html>
                <?php
            } else {
                // Mailer error
                $errorInfo = addslashes($mail->ErrorInfo);
                ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <title>Mailer Error</title>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                </head>
                <body>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Mailer Error',
                            text: '<?php echo $errorInfo; ?>',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            window.location.href = '../?home';
                        });
                    </script>
                </body>
                </html>
                <?php
            }
        } catch (Exception $e) {
            // Exception occurred
            $errorInfo = addslashes($mail->ErrorInfo);
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
                        title: 'Failed to send the password reset email',
                        text: '<?php echo $errorInfo; ?>',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        window.location.href = '../?home';
                    });
                </script>
            </body>
            </html>
            <?php
        }
    } else {
        // No user found with that email
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
                }).then((result) => {
                    window.location.href = '../?home';
                });
            </script>
        </body>
        </html>
        <?php
    }

    $stmt->close();
    $con->close();
} else {
    // Email is required
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
                text: 'Email is required.',
                confirmButtonText: 'OK'
            }).then((result) => {
                window.location.href = '../?home';
            });
        </script>
    </body>
    </html>
    <?php
}
?>
