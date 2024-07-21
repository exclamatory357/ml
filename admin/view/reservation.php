<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Pumpboats</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <?php
    // Enable error reporting
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Include database connection
    include "../../config/db.php";

    // Check database connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    function get_pumpboats($con) {
        $query = "SELECT * FROM pumpboats";
        $result = mysqli_query($con, $query);
        if (!$result) {
            echo "Error: " . mysqli_error($con);
            return;
        }
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$i}</td>
                <td>{$row['license_no']}</td>
                <td>{$row['pumpboat_no']}</td>
                <td>{$row['type']}</td>
          <!--      <td>{$row['category']}</td> 
                <td><img src='uploads/{$row['image']}' alt='Image' width='50' height='50'></td> !-->
                <td>
                    <a href='?pumpboat-edit={$row['id']}' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i> Edit</a>
                    <a href='#' class='btn btn-danger btn-sm' onclick='confirmDelete({$row['id']})'><i class='fa fa-trash'></i> Delete</a>
                </td>
            </tr>";
            $i++;
        }
    }
    ?>

    <?php
    // Manage Pumpboats Section
    if (isset($_GET["manage_pumpboats"])) { ?>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-6">
                        <h1>Manage Pumpboats</h1>
                    </div>
                    <div class="col-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Pumpboats</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
        <div class="box-body">
                    <div class="mb-3">
                        <a href="?pumpboat-add" class="btn btn-success"><i class="fa fa-plus"></i> Add Pumpboat</a>
                    </div>
                    <br>
            <div class="box box-default mt-4">
                <div class="box-header with-border">
                    <h3 class="box-title">Pumpboat List</h3>
                </div>
                
                    <table id="pumpboatTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>License No</th>
                                <th>Pumpboat No</th>
                                <th>Type</th>
                            <!--    <th>Category</th> !-->
                             <!--   <th>Image</th> !-->
                                <th><i class="fa fa-cogs"></i> Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php get_pumpboats($con); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    <?php }

    // Pumpboat Add Section
    if (isset($_GET["pumpboat-add"])) { ?>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-6">
                        <h1><a href="?manage_pumpboats">Back</a></h1>
                    </div>
                    <div class="col-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Pumpboat</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Pumpboat</h3>
                </div>
                <form action="function/function_crud.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="card-body">
                        <div class="row">
                           <div class="col-md-6">
                             <!--   <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Upload Image</label>
                                    <div class="col-sm-8">
                                        <input type="file" accept=".jpg,.jpeg,.png" name="img" class="form-control" required>
                                    </div> 
                                </div> !-->
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">License No.</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="license_no" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Pumpboat No.</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="pumpboat_no" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Type</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="type" required>
                                            <option value="Pamo">Pamo</option>
                                            <option value="Panambahan">Panambahan</option>
                                            <option value="Island Hopping">Island Hopping</option>
                                        </select>
                                    </div>
                                </div>
                             <!--   <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Category</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="category" required>
                                            <option value="Category1">Category1</option>
                                            <option value="Category2">Category2</option>
                                        </select>
                                    </div> 
                                </div>!-->
                          <!--      <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Max Person</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" name="max_person" required>
                                    </div>
                                </div> !-->
                                <div class="form-group row">
                                    <div class="col-sm-8 offset-sm-4">
                                        <button type="submit" class="btn btn-primary" name="btn-pumpboat-add">Submit</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Additional form fields can go here -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    <?php }

    // Pumpboat Edit Section
    if (isset($_GET["pumpboat-edit"])) {
        $getid = $_GET["pumpboat-edit"];
        $stmt = $con->prepare("SELECT * FROM pumpboats WHERE id = ?");
        $stmt->bind_param("i", $getid);
        $stmt->execute();
        $result = $stmt->get_result();
        $fetch = $result->fetch_assoc();
        $stmt->close();

        ?>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-6">
                        <h1><a href="?manage_pumpboats">Back</a></h1>
                    </div>
                    <div class="col-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Pumpboat</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Pumpboat</h3>
                </div>
                <form action="function/function_crud.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">License No.</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($fetch["license_no"]) ?>" name="license_no" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Pumpboat No.</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" class="form-control" value="<?= htmlspecialchars($fetch["id"]) ?>" name="id" required>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($fetch["pumpboat_no"]) ?>" name="pumpboat_no" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Type</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="type" required>
                                           <!-- <option value="Type1" <?= $fetch["type"] == "Type1" ? 'selected' : '' ?>>Type1</option>
                                            <option value="Type2" <?= $fetch["type"] == "Type2" ? 'selected' : '' ?>>Type2</option> !-->
                                            <option value="Pamo">Pamo</option>
                                            <option value="Panambahan">Panambahan</option>
                                            <option value="Island hopping">Island hopping</option>
                                        </select>
                                    </div>
                                </div>
                             <!--   <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Category</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="category" required>
                                            <option value="Category1" <?= $fetch["category"] == "Category1" ? 'selected' : '' ?>>Category1</option>
                                            <option value="Category2" <?= $fetch["category"] == "Category2" ? 'selected' : '' ?>>Category2</option>
                                        </select>
                                    </div>
                                </div> !-->
                         <!--       <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Max Person</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" value="<?= htmlspecialchars($fetch["max_person"]) ?>" name="max_person" required>
                                    </div>
                                </div> !-->
                               
                                <div class="form-group row">
                                    <div class="col-sm-8 offset-sm-4">
                                        <button type="submit" class="btn btn-primary" name="btn-pumpboat-edit">Update</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Additional form fields can go here -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <?php
    }
    ?>

    <!-- Bootstrap and other necessary scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'view/delete_pumpboat.php?id=' + id;
            }
        })
    }
    </script>
</body>
</html>


<?php if (isset($_GET["reserved2"])) { ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-6">
                <h1>Mainitenance & C/A</h1>
            </div>
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Mainitenance & C/A</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="content container-fluid">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Maintenance Requests</h3>
        </div>
        <div class="box-body">
            <table id="example2" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Name</th>
                        <th>Team</th>
                        <th>Request Date</th>
                   <!--     <th>Status</th> !-->
                        <th>Admin Comment</th>
                        <th>Admin Approval</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php get_maintenance_requests($con); ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Cash Advances</h3>
        </div>
        <div class="box-body">
            <table id="example1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php get_cash_advances($con); ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php } ?>






<?php

 if (isset($_GET["reserved"])) {?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-6">
                <h1>Fullypaid</h1>
            </div>
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Fullypaid</li>
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

              <h3 class="box-title"></h3>

            </div>

              <div class="box-body">

                <table id="example2" class="table table-bordered">

                    <thead>

                    <tr>

                       <th>#</th>

                       <th>Transaction #</th>

                       <th>Customer Name</th>

                       <th>Status</th>

                       <th>Date Created</th>

                       <th><i class="fa fa-cogs"></i> Options</th>

                    </tr>

                    </thead>

                    <?php get_confirm($con);?>

                </table>

              </div>

          </div>



</section>

 <?php }

?>


<!-- Manage payment form -->
<?php if (isset($_GET["manage_payment"])) { ?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-6">
                    <h1>Manage Payments</h1>
                </div>
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Payments</li>
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
                <h3 class="box-title"></h3>
            </div>
            <div class="box-body">
                <table id="example2" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th><i class="fa fa-cogs"></i> Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = manage_payment($con);
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td>{$row['id']}</td>
                                        <td>{$row['name']}</td>
                                        <td>{$row['amount']}</td>
                                        <td>{$row['date']}</td>
                                        <td>{$row['status']}</td>
                                        <td>
                                            <button class='btn btn-primary' data-toggle='modal' data-target='#paymentModal-{$row['id']}'>
                                                Process Payment
                                            </button>
                                            <!-- Payment Modal for each row -->
                                            <div class='modal fade' id='paymentModal-{$row['id']}' tabindex='-1' role='dialog' aria-labelledby='paymentModalLabel-{$row['id']}' aria-hidden='true'>
                                                <div class='modal-dialog' role='document'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <h5 class='modal-title' id='paymentModalLabel-{$row['id']}'>Process Payment</h5>
                                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                <span aria-hidden='true'>&times;</span>
                                                            </button>
                                                        </div>
                                                        <form method='post' action='function/function_crud.php'>
                                                            <div class='modal-body'>
                                                                <input type='hidden' name='process_payment' value='1'>
                                                                <input type='hidden' name='advance_id' value='{$row['id']}'>
                                                                <input type='hidden' name='user_id' value='{$row['user_id']}'>
                                                                <div class='form-group'>
                                                                    <label for='payment-amount-{$row['id']}'>Payment Amount</label>
                                                                    <input type='number' name='payment_amount' id='payment-amount-{$row['id']}' class='form-control' required>
                                                                </div>
                                                            </div>
                                                            <div class='modal-footer'>
                                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                                <button type='submit' class='btn btn-primary'>Process</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?php } ?>

<?php

 if (isset($_GET["canceled"])) {?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-6">
                <h1>Canceled</h1>
            </div>
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Canceled</li>
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

              <h3 class="box-title"></h3>

            </div>

              <div class="box-body">

                <table id="example2" class="table table-bordered">

                    <thead>

                    <tr>

                       <th>#</th>

                       <th>Transaction #</th>

                       <th>Customer Name</th>

                       <th>Status</th>

                       <th><i class="fa fa-cogs"></i> Options</th>

                    </tr>

                    </thead>

                    <?php get_cancld($con);?>

                </table>

              </div>

          </div>



</section>

 <?php }

?>



<!-- RESERVATION APPROVED PAGE -->

<?php

 if (isset($_GET["done"])) {?>

     <section class="content-header">

    <h1>

        Done Reservation <span class="badge bg-red">23</span>

    </h1>

    <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Done Reservation</li>

    </ol>

</section>



<!-- Main content -->

<section class="content container-fluid">



<div class="box box-default">

            <div class="box-header with-border">

              <h3 class="box-title"></h3>

            </div>

              <div class="box-body">

                <table id="example2" class="table table-bordered">

                    <thead>

                    <tr>

                        <th>header</th>

                        <th>header</th>

                        <th>header</th>

                        <th>header</th>

                        <th>header</th>

                        <th>header</th>

                        <th>header</th>

                    </tr>

                    </thead>

                    <tbody>

                    <tr>

                        <td>data</td>

                        <td>data</td>

                        <td>data</td>

                        <td>data</td>

                        <td>data</td>

                        <td>data</td>

                        <td>data</td>

                    </tr>

                    </tbody>

                </table>

              </div>

          </div>



</section>

 <?php }

?>