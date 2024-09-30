<?php
// Check if token and email are present in the URL
if (isset($_GET['token']) && isset($_GET['email'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRFAMS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('danorse_house2.jpg'); /* Set this to the background image you prefer */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .reset-container {
            background-color: rgba(255, 255, 255, 0.9); /* Transparent white background */
            padding: 2em;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .reset-container h2 {
            color: #333;
            margin-bottom: 1em;
        }
        .reset-container form {
            display: flex;
            flex-direction: column;
        }
        .reset-container label {
            margin-bottom: 0.5em;
            font-weight: bold;
        }
        .reset-container input[type="password"] {
            padding: 0.7em;
            margin-bottom: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }
        .reset-container button {
            padding: 0.7em;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            margin-bottom: 0.5em;
        }
        .reset-container button:hover {
            background-color: #0056b3;
        }
        .forgot-password {
            background-color: #28a745;
            color: white;
            text-decoration: none;
            padding: 0.7em;
            border-radius: 4px;
            display: inline-block;
            margin-top: 1em;
        }
        .forgot-password:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="reset-container">
    <h2>Reset Your Password</h2>
        <p>DanRose Fishing Management System</p>
    <form action="reset_password_process.php" method="POST">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

        <label for="password">New Password:</label>
        <input type="password" name="password" required>

        <label for="password_confirm">Confirm Password:</label>
        <input type="password" name="password_confirm" required>

        <button type="submit">Reset Password</button>
    </form>
</div>

</body>
</html>
