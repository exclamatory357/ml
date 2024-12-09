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

            <form action="function/function_crud.php" method="post" enctype="multipart/form-data" class="form-horizontal">

              <div class="box-body">

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">

                            <label class="col-sm-4 control-label">Upload Image</label>

                            <div class="col-sm-8">

                            <?php
// If the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['img']['tmp_name'];
        $fileName = $_FILES['img']['name'];
        $fileSize = $_FILES['img']['size'];
        $fileType = $_FILES['img']['type'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Allowed file extensions
        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        // Check if the file extension is valid
        if (!in_array($fileExtension, $allowedExtensions)) {
            die("Error: Invalid file extension. Only JPG, JPEG, and PNG files are allowed.");
        }

        // Check if the file is a valid image
        $imageInfo = getimagesize($fileTmpPath);
        if ($imageInfo === false) {
            die("Error: The uploaded file is not a valid image.");
        }

        // Check if the file size is within limit (e.g., 5MB max)
        if ($fileSize > 5 * 1024 * 1024) {  // 5MB
            die("Error: The file is too large. Maximum size is 5MB.");
        }

        // Generate a unique file name to avoid overwriting
        $newFileName = uniqid('img_', true) . '.' . $fileExtension;

        // Define the upload directory (ensure it is outside of the web root if possible)
        $uploadDir = 'uploads/images/';

        // Ensure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Move the uploaded file to the target directory
        $destPath = $uploadDir . $newFileName;
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            echo "File uploaded successfully: " . htmlspecialchars($newFileName);
        } else {
            die("Error: There was a problem uploading the file.");
        }
    } else {
        die("Error: No file uploaded or an error occurred during the file upload.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .form-group {
            margin: 20px 0;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #AF0401;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #D93B3B;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Upload an Image</div>
        <form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
            <div class="form-group">
                <input type="file" accept=".jpg,.jpeg,.png" name="img" id="fileInput" required>
            </div>
            <button type="submit" class="submit-btn">Upload Image</button>
        </form>
    </div>

    <script>
        document.getElementById('fileInput').addEventListener('change', function() {
            var file = this.files[0];
            var fileSize = file.size / 1024 / 1024; // Size in MB
            var fileName = file.name;
            var fileExtension = fileName.split('.').pop().toLowerCase();

            // Check file size (e.g., max 5MB)
            if (fileSize > 5) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: 'The file size should not exceed 5MB.',
                    confirmButtonText: 'OK'
                });
                this.value = ''; // Clear the file input
                return false;
            }

            // Check file extension (only .jpg, .jpeg, .png)
            if (['jpg', 'jpeg', 'png'].indexOf(fileExtension) === -1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Type',
                    text: 'Only JPG, JPEG, and PNG files are allowed.',
                    confirmButtonText: 'OK'
                });
                this.value = ''; // Clear the file input
                return false;
            }

            // Check MIME type
            var validMimeTypes = ['image/jpeg', 'image/png'];
            if (!validMimeTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid MIME Type',
                    text: 'Only image files (.jpg, .jpeg, .png) are allowed.',
                    confirmButtonText: 'OK'
                });
                this.value = ''; // Clear the file input
                return false;
            }
        });
    </script>
</body>
</html>


                            </div>

                        </div>

                    <!--    <div class="form-group">

                            <label class="col-sm-4 control-label">Name</label>

                            <div class="col-sm-8">

                                <input type="text" class="form-control" name="name" required>

                            </div>

                        </div> 

                        <div class="form-group">

                        <label class="col-sm-4 control-label">Description</label>                       

                        <div class="col-sm-8">

                           <textarea class="form-control" rows="3" placeholder="" name="desc" required></textarea>

                         </div>

                        </div>  !-->

                        <div class="form-group">

                            <label class="col-sm-4 control-label"></label>

                            <div class="col-sm-8">

                                <button type="submit" class="btn btn-primary" name="btn-feature-add">Submit</button>

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