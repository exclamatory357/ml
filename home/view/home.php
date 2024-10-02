<?php
// Start session securely at the beginning of the file
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRMS</title>
  
    <!-- Include reCAPTCHA v3 script -->
    <script src="https://www.google.com/recaptcha/api.js?render=6Lfn3lAqAAAAAIvb5GCgRJBJBRG_5uShpfbGcquW"></script>

    <style>
        /* Your existing styles */
        .carousel-inner img {
            width: 100%;
            height: auto;
        }

        .login-box-body {
            background: rgba(255, 255, 255, 0.8); /* Slightly more opaque background */
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            margin: 0 auto;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
        }

        .p-absolute-login {
            position: absolute;
            top: 50%;
            left: 75%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 400px; /* Adjust width as needed */
            height: auto; /* Ensures height adjusts to content */
            max-height: 900px; /* Optional: limit the max height if content grows */
        }

        .p-absolute-system-title {
            position: absolute;
            top: 10%;
            width: 100%;
            text-align: center;
            color: white;
        }
        
        .carousel-caption {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            color: white;
        }

        @media (max-width: 768px) {
            .p-absolute-login {
                position: absolute;
                top: 5%; /* Adjusted for better mobile view */
                left: 50%;
                transform: translate(-50%, -78%);
                width: 90%; /* Set specific width for medium mobile screens */
                max-width: 95%; /* Allow more width on mobile */
                padding: 15px;
                background: rgba(255, 255, 255, 0.7); /* Slightly more opaque for readability on mobile */
            }
        }

        @media (max-width: 576px) {
            .p-absolute-login {
                position: absolute;
                top: 5%; /* Adjust further for smaller screens */
                left: 50%;
                transform: translate(-50%, -78%);
                width: 95%; /* Set specific width for small mobile screens */
                max-width: 95%;
                padding: 10px;
                background: rgba(255, 255, 255, 0.7); /* Slightly more opaque for readability on mobile */
            }

            .login-box-body {
                padding: 10px; /* Reduce padding on very small screens */
            }
        }

        /* Style for the Sign In button */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        /* Style for the Register button */
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        /* General button styles */
        .btn-block {
            display: block;
            width: 100%;
        }

        .btn-lg {
            font-size: 1.25rem;
            padding: 10px 16px;
        }

    </style>
</head>
<body>

<?php
if (isset($_GET["home"])) { ?>
    <!-- Main content -->
    <section class="">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Carousel content -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="image/danrose_house1.jpg" alt="First slide" class="d-block w-100 img-fluid">
                </div>
                <!-- Additional carousel items can be added here -->
            </div>
        </div>

        <!-- LOGIN PAGE -->
        <?php if (!isset($_SESSION["username"])) { ?>
            <!-- LOGIN FORM, show if session is not set -->
            <div class="login-box-body p-absolute-login container mt-5">
                <p class="login-box-msg text-center">Welcome back!</p>

                <!-- Display error messages -->
                <?php
                if (isset($_SESSION["notify"])) {
                    if ($_SESSION["notify"] == "recaptcha_failed") {
                        echo '<div class="alert alert-danger text-center">reCAPTCHA verification failed. Please try again.</div>';
                        unset($_SESSION["notify"]);
                    } elseif ($_SESSION["notify"] == "invalid") {
                        echo '<div class="alert alert-danger text-center">Invalid username or password.</div>';
                        unset($_SESSION["notify"]);
                    }
                }
                ?>

                <!-- Updated login form with reCAPTCHA v3 -->
                <form id="loginForm" action="function/login.php" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control form-control-lg" placeholder="Enter Username" name="username" required autofocus>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                       <input type="password" class="form-control form-control-lg" placeholder="Enter Password" name="password" required> 
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <!-- Hidden input to store reCAPTCHA token -->
                    <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                    <button type="submit" class="btn btn-primary btn-block btn-lg" name="btnlogin">Sign In</button>
                    
                    <button type="button" data-toggle="modal" data-target="#modal-forgot-password" class="btn btn-success btn-block btn-lg">Forgot password</button> 
                     
                </form>
            </div>
        <?php } ?>

        <!-- FORGOT PASSWORD MODAL -->
        <div class="modal fade" id="modal-forgot-password" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
            <!-- Your existing modal code -->
        </div>

        <!-- MODAL REGISTRATION -->
        <div class="modal fade" id="modal-registration">
            <!-- Your existing modal code -->
        </div>
    </section>

    <!-- Additional sections -->
    <!-- Your existing sections for About and other content -->

<?php } ?>

<!-- Include necessary scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Add the reCAPTCHA execution script before closing body tag -->
<script>
    grecaptcha.ready(function() {
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting immediately
            grecaptcha.execute('6Lfn3lAqAAAAAIvb5GCgRJBJBRG_5uShpfbGcquW', {action: 'login'}).then(function(token) {
                // Add the token to the hidden input field
                document.getElementById('recaptchaResponse').value = token;
                // Submit the form after the token is added
                document.getElementById('loginForm').submit();
            });
        });
    });
</script>

<!-- Your existing script to disable right-click and F12 -->
<script type="text/javascript">
    // Disable right-click with an alert
    document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
        alert("Right-click is disabled on this page.");
    });

    // Disable F12 key and Inspect Element keyboard shortcuts with alerts
    document.onkeydown = function(e) {
        // F12
        if (e.key === "F12") {
            alert("F12 (DevTools) is disabled.");
            e.preventDefault(); // Prevent default action
            return false;
        }
        
        // Ctrl + Shift + I (Inspect)
        if (e.ctrlKey && e.shiftKey && e.key === "I") {
            alert("Inspect Element is disabled.");
            e.preventDefault();
            return false;
        }
        
        // Ctrl + Shift + J (Console)
        if (e.ctrlKey && e.shiftKey && e.key === "J") {
            alert("Console is disabled.");
            e.preventDefault();
            return false;
        }
        
        // Ctrl + U or Ctrl + u (View Source)
        if (e.ctrlKey && (e.key === "U" || e.key === "u" || e.keyCode === 85)) {
            alert("Viewing page source is disabled.");
            e.preventDefault();
            return false;
        }
    };
</script>

</body>
</html>
