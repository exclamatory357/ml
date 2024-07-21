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
                <!-- <th>Image</th> Uncomment if needed -->
                <!-- <th>Cottage No.</th> Uncomment if needed -->
                <th>Name</th>
                <th>Pumpboat No.</th>
             <!--   <th>Max Person</th> !-->
                <th>Category</th>
                <th>Team</th>
                <th><i class="fa fa-cogs"></i></th>
                      
                    </tr>
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

<!-- Main content -->
<!-- Main content -->
<?php

include "../../config/db.php";

// Fetch agent names from the database
function fetch_agents($con) {
    $sql = "SELECT CONCAT(fname, ' ', lname) AS full_name FROM user WHERE user_type_id = 3";
    $query = mysqli_query($con, $sql);
    $agents = [];
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $agents[] = $row;
        }
    }
    return $agents;
}

// Fetch pumpboat numbers from the database
function fetch_pumpboats($con) {
    $sql = "SELECT pumpboat_no, status FROM pumpboats";
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


<!-- Main content -->
<section class="content container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add Agent</h3>
        </div>
        <form action="function/function_crud.php" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Team</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="team" required>
                            </div>
                        </div>
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
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Pumpboat No.</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="type" id="pumpboat-select" required>
                                    <option value="">Select Pumpboats</option>
                                    <?php foreach ($pumpboats as $pumpboat): ?>
                                        <option value="<?php echo $pumpboat['pumpboat_no']; ?>" <?php echo $pumpboat['status'] == 1 ? 'disabled' : ''; ?>>
                                            Pumpboat <?php echo $pumpboat['pumpboat_no']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Type</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="category" required>
                                    <option value="Pamo">Pamo</option>
                                    <option value="Panambahan">Panambahan</option>
                                    <option value="Island hopping">Island hopping</option>
                                </select>
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
            </div>
        </form>
    </div>
</section>


<!-- Bootstrap and other necessary scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


<?php } ?>

<!-- AGENT EDIT FORM -->
<?php if (isset($_GET["cottage-edit"])) { ?>

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


<?php 

$getid = $_GET["cottage-edit"];
$sql = "SELECT * FROM `cottage/hall` WHERE id = '$getid'";
$query = mysqli_query($con, $sql);
$fetch = mysqli_fetch_assoc($query);
?>
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resevation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch agent data
$getid = $_GET["cottage-edit"];
$sql = "SELECT * FROM `cottage/hall` WHERE id = '$getid'";
$query = mysqli_query($conn, $sql);
$fetch = mysqli_fetch_assoc($query);

// Fetch pumpboats data
$sqlPumpboats = "SELECT pumpboat_no, status FROM pumpboats";
$resultPumpboats = $conn->query($sqlPumpboats);

$pumpboats = [];
if ($resultPumpboats->num_rows > 0) {
    while($row = $resultPumpboats->fetch_assoc()) {
        $pumpboats[] = $row;
    }
}
$conn->close();
?>

<section class="content container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Agent</h3>
        </div>
        <form action="function/function_crud.php" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Team</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $fetch["team"] ?>" name="team" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Agent Name</label>
                            <div class="col-sm-8">
                                <input type="hidden" class="form-control" value="<?php echo $fetch["id"] ?>" name="id" required>
                                <input type="text" class="form-control" value="<?php echo $fetch["name"] ?>" name="name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Pumpboat No.</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="category" id="pumpboat-select" required>
                                    <option value="">Select Pumpboats</option> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Type</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="type" required>
                                    <option value="Pamo" <?php if($fetch["type"] == "Pamo") echo "selected"; ?>>Pamo</option>
                                    <!-- Add other types as needed -->
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-8 offset-sm-4">
                                <button type="submit" class="btn btn-primary" name="btn-cottage-edit">Update</button>
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

<script>
    const pumpboats = <?php echo json_encode($pumpboats); ?>;
    
    const pumpboatSelect = document.getElementById('pumpboat-select');
    
    pumpboats.forEach(pumpboat => {
        const option = document.createElement('option');
        option.value = pumpboat.pumpboat_no;
        option.text = 'Pumpboat ' + pumpboat.pumpboat_no;
        if (pumpboat.status == 1) {
            option.disabled = true;
        }
        pumpboatSelect.appendChild(option);
    });

    // Set the selected value
    const selectedCategory = "<?php echo $fetch['category']; ?>";
    if (selectedCategory) {
        pumpboatSelect.value = selectedCategory;
    }
</script>

<?php } ?>

<!-- Bootstrap and other necessary scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
