<?php

if (isset($_GET["gallery"])) {?>
    <!-- Main content -->
    <section class="content">
    <div class="container">
	<div class="row">
		<div class="row">

            <?php get_picture($con)?>

        </div>


        <div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="image-gallery-title"></h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img id="image-gallery-image" class="img-responsive col-md-12" src="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary float-left" id="show-previous-image"><i class="fa fa-arrow-left"></i>
                        </button>

                        <button type="button" id="show-next-image" class="btn btn-secondary float-right"><i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
	</div>
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
    </section>
<?php }?>
