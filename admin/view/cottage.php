<!-- COTTAGE/HALL PAGE -->
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<!-- FontAwesome CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<?php if (isset($_GET["cottage"])) { ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-6">
                <h1>Manage Agents</h1>
            </div>
            <div class="col-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="breadcrumb-item active">Manage Agents</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><a href="?cottage-add" class="btn btn-success"><i class="fa fa-plus"></i> Add Agent</a></h3>
        </div>
        <div class="card-body">
            <table id="example2" class="table table-bordered">
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Pumpboat No.</th>
                    <th>Team</th>
                    <th><i class="fa fa-cogs"></i></th>
                </thead>
                <?php get_cottage($con); ?>
            </table>
        </div>
    </div>
</section>

<?php } ?>

<!-- COTTAGE/HALL ADD FORM -->
<?php if (isset($_GET["cottage-add"])) { ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-6">
                <h1><a href="?cottage">Back</a></h1>
            </div>
            <div class="col-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="breadcrumb-item active">Add Agent</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<?php
include "../../config/db.php";

// Fetch agent names from the database
function fetch_agents($con) {
    $sql = "SELECT CONCAT(fname, ' ', IFNULL(CONCAT(mname, ' '), ''), lname) AS full_name 
            FROM user 
            WHERE user_type_id = 3";
    $query = mysqli_query($con, $sql);
    $agents = [];
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $agents[] = $row;
        }
    }
    return $agents;
}

// Fetch pumpboat numbers and team from the database
function fetch_pumpboats($con) {
    $sql = "SELECT pumpboat_no, team FROM pumpboats";
    $query = mysqli_query($con, $sql);
    $pumpboats = [];
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $pumpboats[] = $row;
        }
    }
    return $pumpboats;
}

$agents = fetch_agents($con);
$pumpboats = fetch_pumpboats($con);
?>

<section class="content container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add Agent</h3>
        </div>
        <form action="function/function_crud.php" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Team Dropdown -->
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Team</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="team" id="team-select" required>
                                    <option value="">Select Team</option>
                                    <?php foreach ($pumpboats as $pumpboat): ?>
                                        <option value="<?php echo $pumpboat['team']; ?>" data-pumpboat="<?php echo $pumpboat['pumpboat_no']; ?>">
                                            <?php echo $pumpboat['team']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Agent Name Dropdown -->
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Agent Name</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="name" required>
                                    <option value="">Select Agent</option>
                                    <?php foreach ($agents as $agent): ?>
                                        <option value="<?php echo $agent['full_name']; ?>">
                                            <?php echo $agent['full_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Pumpboat Dropdown -->
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Pumpboat No.</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="pumpboat_no" id="pumpboat-select" required>
                                    <option value="">Select Pumpboat No.</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-8 offset-sm-4">
                            <button type="submit" class="btn btn-primary" name="btn-cottage-add">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Additional form fields can go here -->
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Bootstrap and other necessary scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
// JavaScript to link the Team and Pumpboat dropdowns
document.getElementById('team-select').addEventListener('change', function() {
    var pumpboatNo = this.options[this.selectedIndex].getAttribute('data-pumpboat');
    var pumpboatSelect = document.getElementById('pumpboat-select');
    
    pumpboatSelect.innerHTML = ''; // Clear current options
    if (pumpboatNo) {
        var option = document.createElement('option');
        option.value = pumpboatNo;
        option.text = 'Pumpboat ' + pumpboatNo;
        pumpboatSelect.appendChild(option);
    }
});
</script>

<?php } ?>

<!-- AGENT EDIT FORM -->
<?php 
if (isset($_GET["cottage-edit"])) { 

    // Fetch the agent details to be edited
    $id = intval($_GET["cottage-edit"]);
    $sql = "SELECT * FROM `cottage/hall` WHERE id = $id";
    $query = mysqli_query($con, $sql);
    $fetch = mysqli_fetch_assoc($query);

    if (!$fetch) {
        echo "<p>Agent not found.</p>";
        exit;
    }

    // Fetch the pumpboat data from the `pumpboats` table
    $sql_pumpboats = "SELECT DISTINCT team, pumpboat_no FROM pumpboats";
    $query_pumpboats = mysqli_query($con, $sql_pumpboats);
    $pumpboats = [];

    if (mysqli_num_rows($query_pumpboats) > 0) {
        while ($row = mysqli_fetch_assoc($query_pumpboats)) {
            $pumpboats[] = $row;
        }
    }

?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-6">
                <h1><a href="?cottage">Back</a></h1>
            </div>
            <div class="col-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="breadcrumb-item active">Edit Agent</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Agent</h3>
        </div>
        <form action="function/function_crud.php" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Team Dropdown -->
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Team</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="team" id="team-select" required>
                                    <option value="">Select Team</option>
                                    <?php 
                                    // Fetch unique teams from the pumpboats data
                                    $unique_teams = array_unique(array_column($pumpboats, 'team'));
                                    foreach ($unique_teams as $team): ?>
                                        <option value="<?php echo $team; ?>" <?php echo ($fetch['team'] == $team) ? "selected" : ""; ?>>
                                            <?php echo $team; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Pumpboat Dropdown -->
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Pumpboat No.</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="pumpboat_no" id="pumpboat-select" required>
                                    <option value="">Select Pumpboat No.</option>
                                    <!-- Options will be populated by JavaScript -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-8 offset-sm-4">
                            <input type="hidden" name="id" value="<?php echo $fetch['id']; ?>">
                            <button type="submit" class="btn btn-primary" name="btn-cottage-edit">Update</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Additional form fields can go here -->
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Include jQuery and Bootstrap Scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    var pumpboats = <?php echo json_encode($pumpboats); ?>;
    var preselectedPumpboatNo = '<?php echo $fetch['pumpboat_no']; ?>';

    // Function to populate pumpboat dropdown based on selected team
    function populatePumpboats(selectedTeam) {
        var pumpboatSelect = $('#pumpboat-select');
        pumpboatSelect.html('<option value="">Select Pumpboat No.</option>'); // Clear current options

        if (selectedTeam) {
            var teamPumpboats = pumpboats.filter(function(pumpboat) {
                return pumpboat.team === selectedTeam;
            });
            teamPumpboats.forEach(function(pumpboat) {
                var selected = '';
                if (pumpboat.pumpboat_no === preselectedPumpboatNo) {
                    selected = ' selected';
                }
                pumpboatSelect.append('<option value="' + pumpboat.pumpboat_no + '"' + selected + '>Pumpboat ' + pumpboat.pumpboat_no + '</option>');
            });
            // If only one pumpboat, auto-select it
            if (teamPumpboats.length === 1) {
                pumpboatSelect.val(teamPumpboats[0].pumpboat_no);
            }
        }
    }

    // When the team dropdown changes, update the pumpboat dropdown
    $('#team-select').on('change', function() {
        var selectedTeam = $(this).val();
        preselectedPumpboatNo = ''; // Clear the preselected pumpboat when team changes
        populatePumpboats(selectedTeam);
    });

    // On page load, populate the pumpboat dropdown
    var preselectedTeam = $('#team-select').val();
    if (preselectedTeam) {
        populatePumpboats(preselectedTeam);
    }
});
</script>

<?php } ?>


<!-- Bootstrap and other necessary scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


<?php
// Check session notification
if (isset($_SESSION["notify"])) {
    switch ($_SESSION["notify"]) {
        // Agent Notifications
        case "duplicate-name-agent":
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Duplicate Name',
                        text: 'An agent with this name already exists!',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            break;
        case "success-add-agent":
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Agent added successfully!',
                        confirmButtonText: 'Great!'
                    });
                  </script>";
            break;
        case "failed-add-agent":
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Failed to add agent. Please try again.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            break;

        // General Notifications
        case "success-add":
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data successfully added.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            break;
        case "failed-add":
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Failed to add data.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            break;

        case "success":
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Operation completed successfully.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            break;

        case "confirm-failed":
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Failed to confirm the action.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            break;

        case "success-delete":
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: 'Data successfully deleted.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            break;

        case "failed-delete":
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Failed to delete data.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            break;

        // Pumpboat Notifications
        case "duplicate-edit-pumpboat":
        case "duplicate-add-pumpboat":
            echo "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplicate Entry',
                        text: 'A pumpboat with this license or pumpboat number already exists.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            break;

        case "success-edit-pumpboat":
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Pumpboat Updated',
                        text: 'The pumpboat has been successfully updated.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            break;

        case "failed-edit-pumpboat":
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'An error occurred while updating the pumpboat.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            break;

        case "success-add-pumpboat":
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Pumpboat Added',
                        text: 'The pumpboat has been successfully added.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            break;

        // Default Case
        default:
            echo "<script>
                    console.warn('Unknown notification type: {$_SESSION['notify']}');
                  </script>";
            break;
    }

    // Unset the notification after displaying it
    unset($_SESSION["notify"]);
}
?>
