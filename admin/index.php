<?php
 session_start();
 include "../config/db.php";
 include "function/function_get.php";
 $datetoday = date("Y-m-d");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>DRFAMS</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php include "shared/link.php"?>

  <!-- Include SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark/dark.css">
  <!-- Include SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body class="hold-transition skin-green-light sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <?php include "shared/header.php"?>
  <!-- sidebar -->
  <?php include "shared/sidebar.php"?>

  <div class="content-wrapper" style="min-height: 1010px;">
    
  <!-- DASHBOARD PAGE -->
  <?php include "view/dashboard.php"?>
  <!-- COTTAGE/HALL PAGE -->
  <?php include "view/cottage.php"?>
  <!-- RESERVATION PAGE -->
  <?php include "view/reservation.php"?>
  <!-- SELL PRODUCT -->
  <?php include "view/sell_product.php"?>
  <!-- MANAGE CATCH BY TEAM -->
  <?php include "view/manage_catch_by_team.php"?>
  <!-- FEATURES PAGE -->
  <?php include "view/features.php"?>
  <!-- PICTURES PAGE -->
  <?php include "view/pictures.php"?>
  <!-- USERS ACCOUNT PAGE -->
  <?php include "view/users.php"?>
  <!-- USERS ACCOUNT PAGE -->
  <?php include "view/feedback.php"?>

  </div>

  <!-- Main Footer -->
  <?php include "shared/footer.php"?>

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<?php include "shared/script.php"?>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .row .col-sm-6:eq(0)');
    
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  $(function () {
    $('#cashAdvances').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
});


$(function () {
    $('#users').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,  // Ensure the table adapts its width
        "responsive": true,  // Make the table responsive
        "columnDefs": [
            { "width": "10%", "targets": 0 },  // Adjust width as necessary for specific columns
            { "width": "20%", "targets": 9 },  // Password and Username might need specific widths
            { "orderable": false, "targets": 10 }  // Disable ordering on action column (edit/delete)
        ]
    });
});


$(function () {
    $('#archieves').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,  // Ensure the table adapts its width
        "responsive": true,  // Make the table responsive
        "columnDefs": [
            { "width": "10%", "targets": 0 },  // Adjust width as necessary for specific columns
            { "width": "20%", "targets": 9 },  // Password and Username might need specific widths
            { "orderable": false, "targets": 10 }  // Disable ordering on action column (edit/delete)
        ]
    });
});

$(function () {
    $('#boang').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,  // Ensure the table adapts its width
        "responsive": true,  // Make the table responsive
        "columnDefs": [
            { "width": "10%", "targets": 0 },  // Adjust width as necessary for specific columns
            { "width": "20%", "targets": 9 },  // Password and Username might need specific widths
            { "orderable": false, "targets": 10 }  // Disable ordering on action column (edit/delete)
        ]
    });
});


$(function () {
    $('#pumpboat').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,  // Ensure the table adapts its width
        "responsive": true,  // Make the table responsive
        "columnDefs": [
            { "width": "10%", "targets": 0 },  // Adjust width as necessary for specific columns
            { "width": "20%", "targets": 9 },  // Password and Username might need specific widths
            { "orderable": false, "targets": 10 }  // Disable ordering on action column (edit/delete)
        ]
    });
});

  // SWEETALERT NOTIFICATION
  document.addEventListener('DOMContentLoaded', (event) => {
    <?php
    // Start the session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION["notify"])) {
        $notify = $_SESSION["notify"];
        unset($_SESSION["notify"]); // Clear the notification after retrieving it

        // Initialize an empty array for Swal options
        $swalOptions = [];

        switch ($notify) {
            // Existing cases
            case "success-add":
                $swalOptions = [
                    'title' => 'Success Add!',
                    'text' => 'Data successfully added.',
                    'icon' => 'success',
                    'timer' => 5000,
                    'timerProgressBar' => true,
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK'
                ];
                break;
            case "success-delete":
                $swalOptions = [
                    'title' => 'Success Delete!',
                    'text' => 'Data successfully deleted.',
                    'icon' => 'success',
                    'timer' => 5000,
                    'timerProgressBar' => true,
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK'
                ];
                break;
            case "failed-add":
                $swalOptions = [
                    'title' => 'Failed!',
                    'text' => 'Failed to add.',
                    'icon' => 'error',
                    'timer' => 5000,
                    'timerProgressBar' => true,
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK'
                ];
                break;
            case "confirm":
                $swalOptions = [
                    'title' => 'Confirmed!',
                    'text' => 'Success confirm.',
                    'icon' => 'success',
                    'timer' => 5000,
                    'timerProgressBar' => true,
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK'
                ];
                break;
            case "failed-adds":
                $swalOptions = [
                    'title' => 'Failed!',
                    'text' => 'Failed to Confirm.',
                    'icon' => 'error',
                    'timer' => 5000,
                    'timerProgressBar' => true,
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK'
                ];
                break;
            case "cancel":
                $swalOptions = [
                    'title' => 'Canceled!',
                    'text' => 'Success cancel.',
                    'icon' => 'success',
                    'timer' => 5000,
                    'timerProgressBar' => true,
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK'
                ];
                break;
            case "cancel-failed":
                $swalOptions = [
                    'title' => 'Failed!',
                    'text' => 'Failed to cancel.',
                    'icon' => 'error',
                    'timer' => 5000,
                    'timerProgressBar' => true,
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK'
                ];
                break;
            case "failed":
                $swalOptions = [
                    'title' => 'Failed!',
                    'icon' => 'error',
                    'timer' => 5000,
                    'timerProgressBar' => true,
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK'
                ];
                break;
            case "success":
                $swalOptions = [
                    'title' => 'Success!',
                    'icon' => 'success',
                    'timer' => 5000,
                    'timerProgressBar' => true,
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK'
                ];
                break;
            case "paid":
                $swalOptions = [
                    'title' => 'Fully paid!',
                    'icon' => 'success',
                    'timer' => 6000,
                    'timerProgressBar' => true,
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK'
                ];
                break;

            // Integrated cases from your first code block
            case "duplicate-edit-pumpboat":
                $swalOptions = [
                    'icon' => 'warning',
                    'title' => 'Duplicate Entry',
                    'text' => 'A pumpboat with this license or pumpboat number already exists.',
                    'confirmButtonText' => 'OK'
                ];
                break;
            case "success-edit-pumpboat":
                $swalOptions = [
                    'icon' => 'success',
                    'title' => 'Pumpboat Updated',
                    'text' => 'The pumpboat has been successfully updated.',
                    'confirmButtonText' => 'OK'
                ];
                break;
            case "failed-edit-pumpboat":
                $swalOptions = [
                    'icon' => 'error',
                    'title' => 'Failed',
                    'text' => 'An error occurred while updating the pumpboat.',
                    'confirmButtonText' => 'OK'
                ];
                break;
            case "success-add-pumpboat":
                $swalOptions = [
                    'icon' => 'success',
                    'title' => 'Pumpboat Added',
                    'text' => 'The pumpboat has been successfully added.',
                    'confirmButtonText' => 'OK'
                ];
                break;
            case "failed-add-pumpboat":
                $swalOptions = [
                    'icon' => 'error',
                    'title' => 'Failed',
                    'text' => 'An error occurred while adding the pumpboat.',
                    'confirmButtonText' => 'OK'
                ];
                break;
            case "duplicate-add-pumpboat":
                $swalOptions = [
                    'icon' => 'warning',
                    'title' => 'Duplicate Entry',
                    'text' => 'A pumpboat with this license or pumpboat number already exists.',
                    'confirmButtonText' => 'OK'
                ];
                break;

            // Integrated cases from your second code block
            case "duplicate-name-agent":
                $swalOptions = [
                    'icon' => 'error',
                    'title' => 'Duplicate Name',
                    'text' => 'An agent with this name already exists!',
                    'confirmButtonText' => 'OK'
                ];
                break;
            case "success-add-agent":
                $swalOptions = [
                    'icon' => 'success',
                    'title' => 'Success',
                    'text' => 'Agent added successfully!',
                    'confirmButtonText' => 'Great!'
                ];
                break;
            case "failed-add-agent":
                $swalOptions = [
                    'icon' => 'error',
                    'title' => 'Failed',
                    'text' => 'Failed to add agent. Please try again.',
                    'confirmButtonText' => 'OK'
                ];
                break;

            default:
                // No action needed if no matching case
                break;
        }

        if (!empty($swalOptions)) {
            // Output the Swal.fire call with properly encoded options
            echo "Swal.fire(" . json_encode($swalOptions) . ");";
        }
    }
    ?>
});

  $("body").on("click", ".view", function(e) {
      e.preventDefault();
      let res_id = $(this).attr("id");
      $.ajax({
          url: "function/view.php",
          type: "POST",
          data: { res_id: res_id },
          cache: false,
          success: function(result) {
              $("div#view-reserve").html(result);
          }
      });
  });

  $(".btnhide").on("click", function() {
      $(".hideme").modal('hide');
  });
</script>

</body>
</html>
