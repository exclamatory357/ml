<?php
include "../../config/db.php"; // Include your database connection

if (
    isset($_POST['email']) &&
    isset($_POST['token']) &&
    isset($_POST['password']) &&
    isset($_POST['password_confirm'])
) {
    $email = strtolower($_POST['email']); // Ensure case-insensitive email comparison
    $token = urldecode($_POST['token']); // Decode the token from the URL
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Check if passwords match
    if ($password !== $password_confirm) {
        // Passwords do not match, display an error message using SweetAlert2
        ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Passwords do not match.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.history.back();
            });
        </script>
        <?php
        exit;
    }

    // Fetch the hashed token and expiry time from the database (case-insensitive email)
    $query = "SELECT reset_token, token_expiry FROM user WHERE LOWER(email) = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Debugging output (temporary)
    if (!$user) {
        echo "Debugging: Email not found - " . htmlspecialchars($email);
    }

    if ($user) {
        $hashedToken = $user['reset_token'];
        $tokenExpiry = $user['token_expiry'];

        // Check if token has expired
        if (new DateTime() > new DateTime($tokenExpiry)) {
            // Token has expired
            ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'This password reset link has expired.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '../?home';
                });
            </script>
            <?php
            exit;
        }

        // Verify the token
        if (password_verify($token, $hashedToken)) {
            // Token is valid, proceed with password update

            // Hash the new password using bcrypt
            $newHashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Update the password in the database
            $query = "UPDATE user SET pass = ?, reset_token = NULL, token_expiry = NULL WHERE LOWER(email) = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("ss", $newHashedPassword, $email);
            if ($stmt->execute()) {
                // Password reset successful
                ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Your password has been reset successfully.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '../?home';
                    });
                </script>
                <?php
            } else {
                // Failed to reset password
                ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to reset your password. Please try again.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.history.back();
                    });
                </script>
                <?php
            }
        } else {
            // Invalid token
            ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Invalid or expired token.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '../?home';
                });
            </script>
            <?php
        }
    } else {
        // No user found with that email
        ?>
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
        <?php
    }

    // Close the statement and connection
    $stmt->close();
    $con->close();
} else {
    // Invalid request
    ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Invalid request.',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = '../?home';
        });
    </script>
    <?php
}
?>
