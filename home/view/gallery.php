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

<script type="text/javascript">
    // Disable right-click
    document.addEventListener('contextmenu', event => event.preventDefault());

    // Disable F12 key and Inspect Element keyboard shortcuts
    document.onkeydown = function(e) {
        if (e.key == "F12" || (e.ctrlKey && e.shiftKey && e.key == "I") || (e.ctrlKey && e.shiftKey && e.key == "J") || (e.ctrlKey && e.key == "U")) {
            return false;
        }
    };
</script>
<?php } ?>