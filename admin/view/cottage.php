<?php
// Start of the PHP script

// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database configuration
include __DIR__ . '/../../config/db.php';

// Function to fetch agent names from the database
function fetch_agents($con) {
    $sql = "SELECT CONCAT(fname, ' ', lname) AS full_name FROM `user` WHERE user_type_id = 3";
    $query = mysqli_query($con, $sql);

    if (!$query) {
        die("Error fetching agents: " . mysqli_error($con));
    }

    $agents = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $agents[] = $row;
    }
    return $agents;
}

// Function to fetch pumpboat numbers from the database
function fetch_pumpboats($con) {
    $sql = "SELECT pumpboat_no FROM pumpboats"; // Adjusted to exclude 'status'
    $query = mysqli_query($con, $sql);

    if (!$query) {
        die("Error fetching pumpboats: " . mysqli_error($con));
    }

    $pumpboats = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $pumpboats[] = $row;
    }
    return $pumpboats;
}

// Function to display the list of agents (cottage/hall)
function get_cottage($con) {
    $sql = "SELECT * FROM `cottage/hall`";
    $query = mysqli_query($con, $sql);
    $i = 1;

    if (mysqli_num_rows($query) > 0) {
        while ($fetch = mysqli_fetch_assoc($query)) {
            echo "
                <tr>
                    <td>".$i."</td>
                    <td>".$fetch['name']."</td>
                    <td>".$fetch['type']."</td>
                    <td>".$fetch['team']."</td>
                    <td>
                        <a href='?cottage-edit=".$fetch['id']."' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i></a>
                        <button type='button' data-toggle='modal' data-target='#modal-delete-".$fetch['id']."' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
                    </td>
                </tr>

                <!-- Modal for delete confirmation -->
                <div class='modal fade' id='modal-delete-".$fetch['id']."' tabindex='-1' role='dialog' aria-labelledby='modalLabel".$fetch['id']."' aria-hidden='true'>
                    <div class='modal-dialog modal-sm' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='modalLabel".$fetch['id']."'>Confirmation</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                <p>Are you sure you want to delete ".$fetch['name']."?</p>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                <a href='function/function_crud.php?cottage-del=".$fetch['id']."' class='btn btn-danger'>Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            ";
            $i++;
        }
    } else {
        echo "<tr><td colspan='5'>No data available</td></tr>";
    }
}

// Fetch agents and pumpboats for use in forms
$agents = fetch_agents($con);
$pumpboats = fetch_pumpboats($con);
?>

<!-- Include necessary CSS and JS files -->
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<!-- FontAwesome CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<!-- Check which page to display based on GET parameters -->
<?php if (isset($_GET["cottage"])) { ?>

    <!-- Manage Agents Page -->
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

    <!-- Main content for Manage Agents -->
    <section class="content container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><a href="?cottage-add" class="btn btn-success"><i class="fa fa-plus"></i> Add Agent</a></h3>
            </div>
            <div class="card-body">
                <table id="agents-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <!-- <th>Image</th> Uncomment if needed -->
                            <!-- <th>Cottage No.</th> Uncomment if needed -->
                            <th>Name</th>
                            <th>Pumpboat No.</th>
                            <th>Team</th>
                            <th><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php get_cottage($con); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

<?php } elseif (isset($_GET["cottage-add"])) { ?>

    <!-- Add Agent Form -->
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

    <!-- Main content for Add Agent -->
    <section class="content container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Agent</h3>
            </div>
            <form action="function/function_crud.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="card-body">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <!-- Team Field -->
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Team</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="team" required>
                                </div>
                            </div>
                            <!-- Agent Name Field -->
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
                            <!-- Pumpboat No. Field -->
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Pumpboat No.</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="pumpboat_no" required>
                                        <option value="">Select Pumpboat</option>
                                        <?php foreach ($pumpboats as $pumpboat): ?>
                                            <option value="<?php echo $pumpboat['pumpboat_no']; ?>">
                                                Pumpboat <?php echo $pumpboat['pumpboat_no']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <div class="form-group row">
                                <div class="col-sm-8 offset-sm-4">
                                    <button type="submit" class="btn btn-primary" name="btn-cottage-add">Submit</button>
                                </div>
                            </div>
                        </div>
                        <!-- Right Column (Additional Fields) -->
                        <div class="col-md-6">
                            <!-- Additional form fields can go here -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

<?php } elseif (isset($_GET["cottage-edit"])) { ?>

    <!-- Edit Agent Form -->
    <?php
    // Fetch agent data based on the ID from the URL
    $getid = $_GET["cottage-edit"];
    $sql = "SELECT * FROM `cottage/hall` WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $getid);
    $stmt->execute();
    $result = $stmt->get_result();
    $fetch = $result->fetch_assoc();

    // Check if agent data was fetched successfully
    if ($fetch === null) {
        echo "No data found for the given ID.";
        exit();
    }
    ?>

    <!-- Content Header -->
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

    <!-- Main content for Edit Agent -->
    <section class="content container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Agent</h3>
            </div>
            <form action="function/function_crud.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="card-body">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <!-- Team Field -->
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Team</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="<?php echo $fetch["team"]; ?>" name="team" required>
                                </div>
                            </div>
                            <!-- Agent Name Field -->
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Agent Name</label>
                                <div class="col-sm-8">
                                    <input type="hidden" class="form-control" value="<?php echo $fetch["id"]; ?>" name="id" required>
                                    <input type="text" class="form-control" value="<?php echo $fetch["name"]; ?>" name="name" required>
                                </div>
                            </div>
                            <!-- Pumpboat No. Field -->
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Pumpboat No.</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="pumpboat_no" required>
                                        <option value="">Select Pumpboat</option>
                                        <?php foreach ($pumpboats as $pumpboat): ?>
                                            <option value="<?php echo $pumpboat['pumpboat_no']; ?>" <?php echo ($fetch['type'] == $pumpboat['pumpboat_no']) ? 'selected' : ''; ?>>
                                                Pumpboat <?php echo $pumpboat['pumpboat_no']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Update Button -->
                            <div class="form-group row">
                                <div class="col-sm-8 offset-sm-4">
                                    <button type="submit" class="btn btn-primary" name="btn-cottage-edit">Update</button>
                                </div>
                            </div>
                        </div>
                        <!-- Right Column (Additional Fields) -->
                        <div class="col-md-6">
                            <!-- Additional form fields can go here -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

<?php } ?>

<!-- Include necessary JS files -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<!-- Initialize DataTables if needed -->
<script>
    $(document).ready(function() {
        $('#agents-table').DataTable();
    });
</script>
