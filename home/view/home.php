<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRMS</title>
  
    <style>
        .carousel-inner img {
            width: 100%;
            height: auto;
        }

        .login-box-body {
            background: rgba(255, 255, 255, 0.7); /* Add a slight background to the form */
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            margin: 0 auto;
        }

        .p-absolute-login {
            position: absolute;
            top: 50%;
            left: 75%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 400px; /* Adjust width as needed */
        }

        .p-absolute-system-title {
            position: absolute;
            top: 10%;
            width: 100%;
            left: 30%;
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
                top: 60%; /* Adjusted for better mobile view */
                left: 50%;
                transform: translate(-50%, -60%);
                max-width: 90%; /* Allow more width on mobile */
                padding: 15px;
                background: rgba(255, 255, 255, 0.9); /* Slightly more opaque for readability on mobile */
            }
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

        <!-- LOGIN PAGE -->
        <?php if (!isset($_SESSION["username"])) { ?>
            <!-- LOGIN FORM, show if session is not set -->
            <div class="login-box-body p-absolute-login container mt-5">
                <p class="login-box-msg text-center">Welcome back!</p>
                <form action="function/login.php" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control form-control-lg" placeholder="Enter Username" name="username" required autofocus>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control form-control-lg" placeholder="Enter Password" name="password" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg" name="btnlogin">Sign In</button>
                    <!-- <button type="button" data-toggle="modal" data-target="#modal-registration" class="btn btn-success btn-block btn-lg">Create Account</button> -->
                </form>
            </div>
        <?php } ?>
        
        <div class="system-title p-absolute-system-title text-center mt-5">
            <span class="text-white display-4">DanRose</span><br>
            <span class="text-white h4">Management System</span>
        </div>

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
            <h3 class="text-center">About</h3>
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
