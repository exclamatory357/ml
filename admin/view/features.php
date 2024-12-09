<?php

 if (isset($_GET["features"])) {?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-6">
                <h1>Features</h1>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Features</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>



<!-- Main content -->

<section class="content container-fluid">



<div class="box box-default">

            <div class="box-header with-border">

              <h3 class="box-title"><a href="?feature-add" class="btn btn-success"><i class="fa fa-plus"></i> New Features</a></h3>

            </div>

              <div class="box-body">

                <table id="example2" class="table table-bordered">

                    <thead>

                    <tr>

                        <th>#</th>

                        <th>Illustration Image</th>

               <!--         <th>Title</th>

                        <th>Description</th>    !-->

                        <th><i class="fa fa-cogs"></i></th>

                    </tr>

                    </thead>

                    <?php get_feature($con);?>

                </table>

              </div>

          </div>



</section>

 <?php }

?>



<!--ADD-->

<?php

 if (isset($_GET["feature-add"])) {?>

     <section class="content-header">

    <h1>

        <a href="?features">Back</a>

    </h1>

    <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Add Features</li>

    </ol>

</section>



<!-- Main content -->
<section class="content container-fluid">

  <div class="box box-default">

    <div class="box-header with-border">
      <h3 class="box-title">Add Feature</h3>
    </div>

    <form action="function/function_crud.php" method="post" enctype="multipart/form-data" class="form-horizontal" id="uploadForm">
      <div class="box-body">
        <div class="row">

          <div class="col-md-6">

            <div class="form-group">
              <label class="col-sm-4 control-label">Upload Image</label>
              <div class="col-sm-8">
                <input type="file" accept=".jpg,.jpeg,.png" name="img" id="fileInput" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label"></label>
              <div class="col-sm-8">
                <button type="submit" class="btn btn-primary" name="btn-feature-add">Submit</button>
              </div>
            </div>

          </div>

          <div class="col-md-6">
            <!-- You can add additional content here if needed -->
          </div>

        </div>
      </div>
    </form>

  </div>

</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Validate image file before form submission
  document.getElementById('uploadForm').onsubmit = function(event) {
    var fileInput = document.getElementById('fileInput');
    var file = fileInput.files[0];

    if (file) {
      var fileSize = file.size / 1024 / 1024; // Size in MB
      var fileName = file.name;
      
      // Extract the file extension
      var fileExtension = fileName.slice(((fileName.lastIndexOf(".") - 1) >>> 0) + 2).toLowerCase();

      // Allowed file extension
      var allowedExtension = 'jpg';

      // Check if the file extension is allowed (it must match exactly)
      if (fileExtension !== allowedExtension) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid File Type',
          text: 'Only .jpg files are allowed.',
          confirmButtonText: 'OK'
        });
        event.preventDefault(); // Prevent form submission
        fileInput.value = ''; // Clear file input
        return false;
      }

      // Check file size (max 5MB)
      if (fileSize > 5) {
        Swal.fire({
          icon: 'error',
          title: 'File Too Large',
          text: 'The file size should not exceed 5MB.',
          confirmButtonText: 'OK'
        });
        event.preventDefault(); // Prevent form submission
        fileInput.value = ''; // Clear file input
        return false;
      }

      // Check MIME type (JPG)
      var validMimeType = 'image/jpeg';
      if (file.type !== validMimeType) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid MIME Type',
          text: 'Only image files (.jpg) are allowed.',
          confirmButtonText: 'OK'
        });
        event.preventDefault(); // Prevent form submission
        fileInput.value = ''; // Clear file input
        return false;
      }
    }

    // If all validations pass, allow form submission
    return true;
  };
</script>



 <?php } ?>



 <!--ADD-->

<?php

if (isset($_GET["feature-edit"])) {?>

    <section class="content-header">

   <h1>
       <a href="?features">Back</a>
   </h1>

   <ol class="breadcrumb">

       <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

       <li class="active">Edit Features</li>

   </ol>

</section>

            <?php 

             $getid = $_GET["feature-edit"];

             $sql = "SELECT * FROM feature WHERE `id` = '$getid'";

             $query = mysqli_query($con, $sql);

             $fetch = mysqli_fetch_assoc($query);

            ?>

<!-- Main content -->

<section class="content container-fluid">



<div class="box box-default">

           <div class="box-header with-border">
              <h3 class="box-title">Add Feature</h3>
           </div>

           <form action="function/function_crud.php" method="post" enctype="multipart/form-data" class="form-horizontal">

             <div class="box-body">

               <div class="row">

                   <div class="col-md-6">

                       <div class="form-group">

                <!--           <label class="col-sm-4 control-label">Name</label>   !-->

                           <div class="col-sm-8">
                               <input type="hidden" value="<?php echo $fetch['id']?>" name="id">
                               <input type="text" class="form-control" value="<?php echo $fetch['name']?>" name="name">

                           </div>

                       </div>

                       <div class="form-group">

               <!--        <label class="col-sm-4 control-label">Description</label>       !-->                 

                       <div class="col-sm-8">

                          <textarea class="form-control" rows="3" placeholder="" name="desc"><?php echo $fetch['desc']?></textarea>

                        </div>

                       </div>

                       <div class="form-group">

                           <label class="col-sm-4 control-label"></label>

                           <div class="col-sm-8">

                               <button type="submit" class="btn btn-primary" name="btn-feature-edit">Submit</button>

                           </div>

                       </div>

                   </div>

                   <div class="col-md-6">



                   </div>

               </div>

             </div>

           </form>

         </div>



</section>

<?php } ?>