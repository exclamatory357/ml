<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://www.google.com/recaptcha/api.js?render=6LdDXo8qAAAAAH1-5iAjDN6HEDN17Tly-GwxcrjZ"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRMS</title>
  
    <style>
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
    top: 10%;
    left: 75%;
    transform: translate(-50%, -38%);
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
                top: 3%; /* Adjusted for better mobile view */
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
        top: 10%; /* Adjust the top placement */
        left: 50%;
        transform: translate(-50%, -39%); /* Center horizontally */
        width: 80%; /* Adjust width to fit smaller screens */
        padding: 20px;
        background: rgba(255, 255, 255, 0.7); /* Maintain readability */
        height: auto; /* Ensure the height grows with content */
        min-height: 300px; /* Provide enough height */
        max-height: 420px; /* Restrict excessive growth */
        overflow-y: auto; /* Add scroll for content overflow */
    }
    
    .login-box-body {
        padding: 15px; /* Add padding for better spacing */
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



/* Center modal */
.modal-dialog {
    display: flex;
    justify-content: center;
    align-items: center;
    max-width: 600px;
    margin: auto;
}

/* Modal content styling */
.modal-content {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Modal header */
.modal-header {
    background-color: #007bff;
    color: white;
}

/* Modal footer */
.modal-footer {
    justify-content: flex-end;
}

/* Add a background color and padding to the modal body */
.modal-body {
    padding: 20px;
    font-size: 1rem;
    line-height: 1.6;
}

    </style>
</head>
<body>

<?php
if (isset($_GET["home"])) { ?>
    <!-- Main content -->
    <section class="">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Carousel indicators commented out -->
            <!-- <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
            </ol> -->
            <div class="carousel-inner">
                <div class="carousel-item active">
               
                    <img src="image/danrose_house1.jpg" alt="First slide" class="d-block w-100 img-fluid">
                    
                    <!-- Carousel captions commented out -->
                    <!-- <div class="carousel-caption">
                        First Slide
                    </div> -->
                </div>
                <!-- Additional carousel items commented out -->
                <!-- <div class="carousel-item">
                    <img src="image/danrose3.jpg" alt="Second slide" class="d-block w-100 img-fluid">
                    <div class="carousel-caption">
                        Second Slide
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="image/danrose.jpg" alt="Third slide" class="d-block w-100 img-fluid">
                    <div class="carousel-caption">
                        Third Slide
                    </div>
                </div> -->
            </div>
            <!-- Carousel controls commented out -->
            <!-- <a class="carousel-control-prev" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a> -->
        </div>

        <?php
session_start();
$login_disabled = false;
$remaining_time = 0;

if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 3) {
    $remaining_time = $_SESSION['timeout'] - time();
    if ($remaining_time > 0) {
        $login_disabled = true;
    } else {
        $_SESSION['login_attempts'] = 0;
        unset($_SESSION['timeout']);
    }
}
?>

<div class="login-box-body p-absolute-login container mt-5">
   <p class="login-box-msg text-center">Welcome back!</p>
    <form action="function/login.php" method="post">
    <div class="form-group has-feedback">
        <input type="text" class="form-control form-control-lg" placeholder="Enter Username" name="username" required autofocus>
    </div>
    <div class="form-group has-feedback">
        <input type="password" class="form-control form-control-lg" placeholder="Enter Password" name="password" required>
    </div>
    
    <!-- Terms and Conditions Checkbox -->
    <div class="form-group">
        <label>
        <input type="checkbox" name="terms" id="termsCheckbox" required>
I agree to the 
<button type="button" class="btn btn-link" data-toggle="modal" data-target="#termsModal">Terms and Conditions</button>

<script>
    // Automatically check the checkbox when the page loads
    $(document).ready(function() {
        $('#termsCheckbox').prop('checked', true);
    });
</script>

        </label>
    </div>

    <button type="submit" class="btn btn-primary btn-block btn-lg" name="btnlogin" 
        <?php if ($login_disabled) echo 'disabled'; ?>>
        <?php if ($login_disabled) {
            echo "Login disabled. Try again in " . ceil($remaining_time / 60) . " minute(s)";
        } else {
            echo "Sign In";
        } ?>
    </button>
    <button type="button" data-toggle="modal" data-target="#modal-forgot-password" class="btn btn-success btn-block btn-lg">Forgot password</button>
</form>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <h1>Terms and Conditions for DanRose Fishing Agency Management System (DRFAMS)</h1>

<h2>1. Acceptance of Terms</h2>
<p>By accessing or using the DanRose Fishing Agency Management System (DRFAMS), you agree to comply with and be bound by these Terms and Conditions. If you do not agree with any part of these terms, please do not use the system.</p>

<h2>2. Purpose of the System</h2>
<p>DRFAMS is designed to optimize the operations of fishing agencies. It integrates various functionalities to manage and monitor the daily performance and records of agents involved in fishing operations. The system aims to enhance productivity and improve overall management, providing a user-friendly platform for all users, including administrators.</p>

<h2>3. User Registration and Account Security</h2>
<ol>
    <li>Users must register and create an account to access certain features of DRFAMS. Admins will create and manage these accounts to ensure appropriate access levels and security.</li>
    <li>The system includes different user roles, including administrators who have elevated privileges to manage system settings and user accounts. Admins are authorized only to request cash advances and manage maintenance requests within the system.</li>
    <li>Users are responsible for maintaining the confidentiality of their login credentials and agree to notify the system administrator immediately if they suspect any unauthorized use of their account.</li>
    <li>The system reserves the right to suspend or terminate an account that violates the terms outlined in this document.</li>
</ol>

<h2>4. Admin Account Responsibilities</h2>
<ol>
    <li>Admin accounts have access to system-wide settings and user management functionalities necessary for maintaining the system.</li>
    <li>Admins are limited to requesting cash advances and managing maintenance requests only. Any other system functions and data access are restricted based on user roles.</li>
    <li>Admins must ensure their account is secured and take appropriate measures to prevent unauthorized access.</li>
</ol>

<h2>5. System Usage</h2>
<ol>
    <li>DRFAMS must be used for legitimate business purposes related to the fishing agency's operations.</li>
    <li>Users agree not to use the system for any unlawful, fraudulent, or harmful activities.</li>
    <li>Users shall not disrupt, interfere, or engage in unauthorized access to the system’s network or servers.</li>
</ol>

<h2>6. Data Privacy and Protection</h2>
<ol>
    <li>DRFAMS takes user privacy and data protection seriously. Any data collected will be handled in accordance with applicable data protection laws and regulations.</li>
    <li>Users consent to the collection and use of personal and operational data for the purposes of system functionality and improvement.</li>
</ol>

<h2>7. Intellectual Property</h2>
<ol>
    <li>All content, features, and functionalities within DRFAMS are the property of DanRose Fishing Agency Management System and are protected by copyright, trademark, and other intellectual property laws.</li>
    <li>Users are prohibited from copying, modifying, distributing, or replicating any part of the system without prior written consent.</li>
</ol>

<h2>8. System Availability and Downtime</h2>
<ol>
    <li>While DRFAMS aims to provide continuous service, the system may experience interruptions or downtime for maintenance, updates, or unforeseen technical issues.</li>
    <li>The system will make reasonable efforts to minimize any disruptions and notify users of scheduled maintenance in advance when possible.</li>
</ol>

<h2>9. Liability Disclaimer</h2>
<ol>
    <li>DRFAMS makes no guarantees or warranties regarding the accuracy, completeness, or performance of the system.</li>
    <li>Users agree to use the system at their own risk. DanRose Fishing Agency Management System is not liable for any damages resulting from system use, including but not limited to data loss, financial losses, or operational disruptions.</li>
</ol>

<h2>10. Termination of Access</h2>
<ol>
    <li>DRFAMS reserves the right to terminate or suspend access to the system for users who violate these Terms and Conditions.</li>
    <li>The system may also suspend access due to scheduled maintenance or technical reasons, with prior notice when feasible.</li>
</ol>

<h2>11. Amendments</h2>
<p>DRFAMS reserves the right to modify or update these Terms and Conditions at any time. Users will be notified of any changes, and continued use of the system after such notifications constitutes acceptance of the revised terms.</p>

<h2>12. Governing Law</h2>
<p>These Terms and Conditions are governed by and construed in accordance with the laws applicable in the jurisdiction where DRFAMS operates.</p>

<h2>13. Contact Information</h2>
<p>For any questions or concerns regarding these Terms and Conditions, please contact our support team at [insert contact email/phone].</p>

<p>By using DRFAMS, you acknowledge that you have read, understood, and agree to these Terms and Conditions.</p>
            </div>
            <div class="modal-footer">
            <h3 style="font-size: 15px;">
                <p>DanRose Fishing Agency Management System       
                         Copyright © 2024-2025 All rights reserved.</p>
            </h3>
            </div>
        </div>
    </div>
</div>


        
        
                <!-- FORGOT PASSWORD MODAL -->
<div class="modal fade" id="modal-forgot-password" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="function/forgot_password.php" method="post">
                <div class="form-group has-feedback">
                <label for="email">Enter your registered email address:</label>
                <input 
                    type="email" 
                    id="email" 
                    class="form-control form-control-lg" 
                    placeholder="Email" 
                    name="email" 
                    required 
                    autofocus 
                    maxlength="254" 
                    pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$"
                >
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg" name="btn-forgot-password">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


       <!-- <div class="system-title p-absolute-system-title text-center mt-5">
            <span class="text-white display-4">DanRose</span><br>
            <span class="text-white h4">Management System</span>
        </div> !--> 

        <!-- MODAL REGISTRATION -->
        <div class="modal fade" id="modal-registration">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title">Registration</h4>
                    </div>
                    <div class="modal-body">
                        <form action="function/function_crud.php" method="post">
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control form-control-lg" placeholder="First Name" name="fname" required autofocus>
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control form-control-lg" placeholder="Lastname" name="lname" required>
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="number" class="form-control form-control-lg" placeholder="Contact no." name="contact" required>
                                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <textarea class="form-control form-control-lg" rows="3" placeholder="Address" name="address"></textarea>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control form-control-lg" placeholder="Username" name="username" required>
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" class="form-control form-control-lg" placeholder="Password" name="password" required>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn-lg" name="btn-reg">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container my-5">
           <br><br><br><br><br><br><br><br> <h3 class="text-center">About</h3>
            <div class="swiper mySwiper mt-4">
                <div class="swiper-wrapper">
                    <?php get_feature($con) ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section> 

    <section>
        <div class="container my-5">
            <h3 style="text-align: justify; margin: 20px;">
                DanRose Fishing Agency Management System (DRFAMS) is designed to optimize the operations of fishing agencies. This system integrates various functionalities to manage and monitor the daily performance and record of agents involved in this agency. DRFAMS is to enhance productivity and improve the overall management of fishing and user-friendly platform.
            </h3>
        </div>
        <div class="container my-5">
            <div class="swiper mySwiper mt-4">
                <div class="swiper-wrapper">
                    <!-- Additional swiper slides -->
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
<?php } ?>

<script>
  grecaptcha.ready(function() {
      // Generate a token for the 'login' action
      grecaptcha.execute('6LdDXo8qAAAAAH1-5iAjDN6HEDN17Tly-GwxcrjZ', { action: 'login' }).then(function(token) {
          // Send the token to your server for verification via an AJAX request
          fetch('function/verify_recaptcha.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: JSON.stringify({ recaptcha_response: token })
          })
          .then(response => response.json())
          .then(data => {
              if (!data.success || data.score < 0.5) {
                  // Disable login functionality if the score is too low
                  document.querySelector('[name="btnlogin"]').disabled = true;
                  alert('Suspicious activity detected. Please try again later.');
              }
          })
          .catch(error => {
              console.error('Error verifying reCAPTCHA:', error);
          });
      });
  });
</script>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

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

