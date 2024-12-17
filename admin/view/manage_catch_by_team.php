<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION)) {
    session_start();
}

// Manage Catch By Team Section
if (isset($_GET["manage_catch_by_team"])) { ?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-6">
                    <h1>Catch by Team</h1>
                </div>
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Catch by Team</li>
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
                <a href="?catch-add" class="btn btn-success"><i class="fa fa-plus"></i> Add Catch Record</a>
            </div>
            <br>
            <div class="box box-default mt-4">
                <div class="box-header with-border">
                    <h3 class="box-title">Catch Records by Team</h3>
                </div>
                
                <div class="table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Team</th>
                                <th>Catch Item</th>
                                <th>Catch Amount (&#8369;)</th>
                                <th>Catch Kilo (kg)</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM catch_records ORDER BY id ASC";
                            $result = mysqli_query($con, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                $count = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $count . "</td>";
                                    echo "<td>" . htmlspecialchars($row['team']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['catch_item']) . "</td>";
                                    echo "<td>&#8369; " . htmlspecialchars($row['catch_amount']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['catch_kilo']) . " kg</td>";
                                    echo "<td>" . htmlspecialchars($row['catch_date']) . "</td>";
                                    echo "</tr>";
                                    $count++;
                                }
                            } else {
                                echo "<tr><td colspan='6'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- SweetAlert Delete Confirmation Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('?catch-del=' + id)
                        .then(response => response.text())
                        .then(data => {
                            Swal.fire('Deleted!', 'The record has been deleted.', 'success').then(() => {
                                window.location.href = '?manage_catch_by_team';
                            });
                        })
                        .catch(error => {
                            Swal.fire('Error!', 'There was an issue deleting the record.', 'error');
                        });
                }
            });
        }
    </script>
<?php }

// Catch Add Section
if (isset($_GET["catch-add"])) { ?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-6">
                    <h1><a href="?manage_catch_by_team">Back</a></h1>
                </div>
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Catch Record</li>
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
                <h3 class="card-title">Add Catch Record</h3>
            </div>
            <form id="catch-form" action="function/function_crud.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Team</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="team" required>
                                        <option value="">Select Team</option>
                                        <?php
                                        $sqlTeams = "SELECT team FROM pumpboats";
                                        $resultTeams = mysqli_query($con, $sqlTeams);
                                        while ($rowTeam = mysqli_fetch_assoc($resultTeams)) {
                                            echo "<option value='" . htmlspecialchars($rowTeam['team']) . "'>" . htmlspecialchars($rowTeam['team']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div id="catch-items-container">
                                <div class="form-group row catch-item">
                                    <label class="col-sm-4 col-form-label">Catch Item</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="catch_item[]" required>
                                            <option value="">Select Item</option>
                                            <option value="Nukos" data-amount="240">Nukos</option>
                                            <option value="Buraw" data-amount="180">Buraw</option>
                                            <option value="Kapisnon" data-amount="80">Kapisnon</option>
                                            <option value="Tabugok" data-amount="60">Tabugok</option>
                                            <option value="Bukaw-Bukaw" data-amount="150">Bukaw-Bukaw</option>
                                            <option value="Danggit" data-amount="80">Danggit</option>
                                            <option value="Nylon-Nylon" data-amount="80">Nylon-Nylon</option>
                                            <option value="Balila" data-amount="50">Balila</option>
                                            <option value="Talho" data-amount="50">Talho</option>
                                            <option value="Katambak" data-amount="180">Katambak</option>
                                            <option value="Ampahan" data-amount="180">Ampahan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Catch Amount</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" name="catch_amount[]" required min="0" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Catch Kilo (kg)</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" name="catch_kilo[]" required min="0" step="0.01">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" id="add-catch-item">Add Another Catch Item</button>
                            <div class="form-group row mt-4">
                                <label class="col-sm-4 col-form-label">Date</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" name="catch_date" required value="<?php echo date('Y-m-d'); ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8 offset-sm-4">
                                    <button type="submit" class="btn btn-primary" name="btn-catch-add">Submit</button>
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
        document.getElementById('add-catch-item').addEventListener('click', function() {
            const container = document.getElementById('catch-items-container');
            const newItem = document.createElement('div');
            newItem.classList.add('catch-item');
            newItem.innerHTML = `
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Catch Item</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="catch_item[]" required>
                            <option value="">Select Item</option>
                            <option value="Nukos" data-amount="240">Nukos</option>
                            <option value="Buraw" data-amount="180">Buraw</option>
                            <option value="Kapisnon" data-amount="80">Kapisnon</option>
                            <option value="Tabugok" data-amount="60">Tabugok</option>
                            <option value="Bukaw-Bukaw" data-amount="150">Bukaw-Bukaw</option>
                            <option value="Danggit" data-amount="80">Danggit</option>
                            <option value="Nylon-Nylon" data-amount="80">Nylon-Nylon</option>
                            <option value="Balila" data-amount="50">Balila</option>
                            <option value="Talho" data-amount="50">Talho</option>
                            <option value="Katambak" data-amount="180">Katambak</option>
                            <option value="Ampahan" data-amount="180">Ampahan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Catch Amount</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="catch_amount[]" required min="0" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Catch Kilo (kg)</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="catch_kilo[]" required min="0" step="0.01">
                    </div>
                </div>
            `;
            container.appendChild(newItem);
        });

        document.addEventListener('change', function(e) {
            if (e.target && e.target.matches("select[name='catch_item[]']")) {
                const selectedOption = e.target.options[e.target.selectedIndex];
                const amount = selectedOption.getAttribute('data-amount');
                if (amount) {
                    const catchAmountInput = e.target.closest('.form-group.row').nextElementSibling.querySelector("input[name='catch_amount[]']");
                    catchAmountInput.value = amount;
                }
            }
        });
    </script>
<?php }

// Insert Operation CATCH BY TEAM
if (isset($_POST["btn-catch-add"])) {
    $team = $_POST["team"];
    $catch_items = $_POST["catch_item"];
    $catch_amounts = $_POST["catch_amount"];
    $catch_kilos = $_POST["catch_kilo"];
    $catch_date = $_POST["catch_date"];

    foreach ($catch_items as $index => $catch_item) {
        $catch_amount = $catch_amounts[$index];
        $catch_kilo = $catch_kilos[$index];
        $sqlCatch = "INSERT INTO `catch_records`(`team`, `catch_item`, `catch_amount`, `catch_kilo`, `catch_date`) 
                     VALUES('$team','$catch_item','$catch_amount','$catch_kilo','$catch_date')";
        $query = mysqli_query($con, $sqlCatch);

        if (!$query) {
            $_SESSION["notify"] = "failed-add";
            header("location: ../?manage_catch_by_team");
            exit();
        }
    }

    $_SESSION["notify"] = "success-add";
    $_SESSION["print_ready_team"] = $team;  // Set session for print with team information
    header("location: ../?manage_catch_by_team");
    exit();
}

// Delete Operation CATCH BY TEAM
if (isset($_GET["catch-del"])) {
    $id = $_GET["catch-del"];
    $sql = "DELETE FROM `catch_records` WHERE id = '$id'";
    $query = mysqli_query($con);

    if ($query) {
        $_SESSION["notify"] = "success-delete";
        header("location: ../?manage_catch_by_team");
        exit();
    } else {
        $_SESSION["notify"] = "failed-delete";
        header("location: ../?manage_catch_by_team");
        exit();
    }
}


?>
