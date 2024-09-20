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
  <title>DRMS</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php include "shared/link.php"?>

  <!-- Include SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark/dark.css">
  <!-- Include SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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


  // SWEETALERT NOTIFICATION
  document.addEventListener('DOMContentLoaded', (event) => {
    <?php if (isset($_SESSION["notify"])) {
        $notify = $_SESSION["notify"];
        unset($_SESSION["notify"]);
    ?>
    let notification = "<?php echo $notify; ?>";
    switch(notification) {
        case "success-add":
            Swal.fire({
                title: 'Success Add!',
                text: 'Data successfully added.',
                icon: 'success',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
            break;
        case "success-delete":
            Swal.fire({
                title: 'Success Delete!',
                text: 'Data successfully deleted.',
                icon: 'success',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
            break;
        case "failed-add":
            Swal.fire({
                title: 'Failed!',
                text: 'Failed to add.',
                icon: 'error',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
            break;
        case "confirm":
            Swal.fire({
                title: 'Confirmed!',
                text: 'Success confirm.',
                icon: 'success',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
            break;
        case "failed-adds":
            Swal.fire({
                title: 'Failed!',
                text: 'Failed to Confirm.',
                icon: 'error',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
            break;
        case "cancel":
            Swal.fire({
                title: 'Canceled!',
                text: 'Success cancel.',
                icon: 'success',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
            break;
        case "cancel-failed":
            Swal.fire({
                title: 'Failed!',
                text: 'Failed to cancel.',
                icon: 'error',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
            break;
        case "failed":
            Swal.fire({
                title: 'Failed!',
                icon: 'error',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
            break;
        case "success":
            Swal.fire({
                title: 'Success!',
                icon: 'success',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
            break;
        case "paid":
            Swal.fire({
                title: 'Fully paid!',
                icon: 'success',
                timer: 6000,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
            break;
        default:
            break;
    }
    <?php } ?>
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
