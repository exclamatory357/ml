<?php
include "../../config/db.php"; // Include your database connection

if (
    isset($_POST['email']) &&
    isset($_POST['token']) &&
    isset($_POST['password']) &&
    isset($_POST['password_confirm'])
) {
    $email = trim(strtolower($_POST['email'])); // Ensure email is case-insensitive and sanitized
    $token = urldecode($_POST['token']); // Decode token from URL
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Debugging output
    echo "Debugging: Token from form - " . htmlspecialchars($token) . "<br>";

    // Check if passwords match
    if ($password !== $password_confirm) {
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

    // Fetch the hashed token and expiry time from the database
    $query = "SELECT reset_token, token_expiry FROM user WHERE email = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $hashedToken = $user['reset_token'];
        $tokenExpiry = $user['token_expiry'];

        // Debugging output for token and expiry
        echo "Debugging: Hashed token from DB - " . htmlspecialchars($hashedToken) . "<br>";
        echo "Debugging: Token expiry from DB - " . $tokenExpiry . "<br>";

        // Check if token has expired
        if (new DateTime() > new DateTime($tokenExpiry)) {
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
            $query = "UPDATE user SET pass = ?, reset_token = NULL, token_expiry = NULL WHERE email = ?";
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
            echo "Debugging: Token verification failed.<br>"; // Add this for debugging
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
