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
           <!-- Button to trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAgentModal">
  Add Agent
</button>
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
           <!--     <th>Category</th> !-->
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






<!-- Modal -->
<div class="modal fade" id="addAgentModal" tabindex="-1" role="dialog" aria-labelledby="addAgentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addAgentModalLabel">Add Agent</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="function/function_crud.php" method="post" enctype="multipart/form-data" class="form-horizontal">
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
            <div class="col-sm-8 offset-sm-4">
              <button type="submit" class="btn btn-primary" name="btn-cottage-add">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Main content -->
<!-- Main content -->



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
                      <!--  <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Type</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="category" required>
                                    <option value="Pamo">Pamo</option>
                                    <option value="Panambahan">Panambahan</option>
                                    <option value="Island hopping">Island hopping</option>
                                </select>
                            </div> !-->
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
                                <select class="form-control" name="type" id="pumpboat-select" required>
                                    <option value="">Select Pumpboats</option> 
                                </select>
                            </div>
                        </div>
                  <!--      <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Type</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="type" required>
                                    <option value="Pamo" <?php if($fetch["type"] == "Pamo") echo "selected"; ?>>Pamo</option>
                                    
                                </select>
                            </div>
                        </div> !-->
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
