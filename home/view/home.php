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
            background: rgba(255, 255, 255, 0.7);
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
            max-width: 400px;
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
                top: 5%;
                left: 50%;
                transform: translate(-50%, -78%);
                width: 90%;
                max-width: 95%;
                padding: 15px;
                background: rgba(255, 255, 255, 0.7);
            }
        }

        @media (max-width: 576px) {
            .p-absolute-login {
                top: 5%;
                left: 50%;
                transform: translate(-50%, -78%);
                width: 95%;
                max-width: 95%;
                padding: 10px;
                background: rgba(255, 255, 255, 0.7);
            }

            .login-box-body {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<?php
session_start(); // Always start session first

// CSRF Token generation (secure against cross-site request forgery)
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32)); // generate a random token
}

function sanitizeInput($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // prevent XSS
}

if (isset($_GET["home"])) { ?>
    <section>
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="image/danrose_house1.jpg" alt="First slide" class="d-block w-100 img-fluid">
                </div>
            </div>
        </div>

        <?php if (!isset($_SESSION["username"])) { ?>
            <div class="login-box-body p-absolute-login container mt-5">
                <p class="login-box-msg text-center">Welcome back!</p>
                <form action="function/login.php" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control form-control-lg" placeholder="Enter Username" name="username" required autofocus>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control form-control-lg" placeholder="Enter Password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg" name="btnlogin">Sign In</button>
                </form>
            </div>
        <?php } ?>

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
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control form-control-lg" placeholder="First Name" name="fname" required autofocus>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control form-control-lg" placeholder="Lastname" name="lname" required>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="number" class="form-control form-control-lg" placeholder="Contact no." name="contact" required>
                            </div>
                            <div class="form-group has-feedback">
                                <textarea class="form-control form-control-lg" rows="3" placeholder="Address" name="address"></textarea>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control form-control-lg" placeholder="Username" name="username" required>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" class="form-control form-control-lg" placeholder="Password" name="password" required>
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
                    <?php get_feature($con); ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <section>
        <div class="container my-5">
            <h3 style="text-align: justify; margin: 20px;">
                DanRose Fishing Agency Management System (DRFAMS) is designed to optimize the operations of fishing agencies...
            </h3>
        </div>
        <div class="container my-5">
            <div class="swiper mySwiper mt-4">
                <div class="swiper-wrapper">
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
