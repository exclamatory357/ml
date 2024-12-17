<?php 

// admin side form request

function get_maintenance_requests($con) {
    $sql = "SELECT * FROM maintenance_requests";
    $query = mysqli_query($con, $sql);
    $i = 1;

    if (mysqli_num_rows($query) > 0) {
        while ($fetch = mysqli_fetch_assoc($query)) {
            echo "
            <tr>
                <td>".$i."</td>
                <td>".htmlspecialchars($fetch["item_name"])."</td>
                <td>".htmlspecialchars($fetch["description"])."</td>
                <td>".htmlspecialchars($fetch["request_date"])."</td>
                <td>".htmlspecialchars($fetch["admin_comment"])."</td>
                <td>".htmlspecialchars($fetch["admin_approval"])."</td>
                <td>";

            // Disable buttons if status is "Approved"
            $disabled = $fetch['admin_approval'] === 'Approved' ? 'disabled' : '';

            echo "
                <button type='button' data-toggle='modal' data-target='#modal-edit-".$fetch['id']."' class='btn btn-warning edit' id='".$fetch['id']."' $disabled>
                    <i class='fa fa-edit'></i>
                </button>
                <button type='button' data-toggle='modal' data-target='#modal-delete-".$fetch['id']."' class='btn btn-danger delete' id='".$fetch['id']."' $disabled>
                    <i class='fa fa-trash'></i>
                </button>
            </td>
            </tr>";

            // Edit Modal
            echo "<div class='modal fade' id='modal-edit-".$fetch['id']."'>
                <div class='modal-dialog modal-lg'>
                    <div class='modal-content'>
                        <div class='modal-header bg-primary'>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>×</span></button>
                            <h4 class='modal-title'>Edit Maintenance Request ID: ".$fetch['id']."</h4>
                        </div>
                        <div class='modal-body'>
                            <form method='post' action='function/function_crud.php'>
                                <input type='hidden' name='update_maintenance_request' value='1'>
                                <input type='hidden' name='id' value='".$fetch['id']."'>
                                <label>Item Name: </label> 
                                <input type='text' name='item_name' value='".htmlspecialchars($fetch["item_name"])."' class='form-control' readonly><br>
                                <label>Team: </label> 
                                <input type='text' name='description' value='".htmlspecialchars($fetch["description"])."' class='form-control' readonly><br>
                                <label>Request Date: </label> 
                                <input type='date' name='request_date' value='".htmlspecialchars($fetch["request_date"])."' class='form-control' readonly><br>
                                
                                <label>Admin Comment: </label> 
                                <input type='text' name='admin_comment' value='".htmlspecialchars($fetch["admin_comment"])."' 
                                       class='form-control' maxlength='100' 
                                       pattern='[A-Za-z0-9 ]*' 
                                       title='Only letters and numbers are allowed, with a maximum length of 100 characters.'
                                       ".($fetch['admin_approval'] === 'Approved' ? 'readonly' : '')."><br>
                                
                                <label>Admin Approval: </label>
                                <select name='admin_approval' class='form-control' ".($fetch['admin_approval'] === 'Approved' ? 'disabled' : '').">
                                    <option value='Pending'".($fetch["admin_approval"] == 'Pending' ? ' selected' : '').">Pending</option>
                                    <option value='Approved'".($fetch["admin_approval"] == 'Approved' ? ' selected' : '').">Approved</option>
                                </select>
                                <br><br>
                        </div>
                        <div class='modal-footer'>
                            <button type='submit' class='btn btn-primary' ".($fetch['admin_approval'] === 'Approved' ? 'disabled' : '').">Update</button>
                            <button type='button' class='btn bg-maroon' data-dismiss='modal'>Close</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>";

            // Delete Modal
            echo "<div class='modal fade' id='modal-delete-".$fetch['id']."'>
                <div class='modal-dialog modal-sm'>
                    <div class='modal-content'>
                        <div class='modal-header bg-danger'>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>×</span></button>
                            <h4 class='modal-title'>Delete Confirmation</h4>
                        </div>
                        <div class='modal-body'>
                            <center><h3>Are you sure you want to delete this request?</h3></center>
                        </div>
                        <div class='modal-footer'>
                            <form method='post' action='function/function_crud.php'>
                                <input type='hidden' name='delete_maintenance_request' value='1'>
                                <input type='hidden' name='id' value='".$fetch['id']."'>
                                <button type='submit' class='btn btn-danger' ".($fetch['admin_approval'] === 'Approved' ? 'disabled' : '').">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>";

            $i++;
        }
    }
}



function get_cash_advances($con) {
    // Modify the query to exclude records with an amount of 0
    $sql = "SELECT * FROM cash_advances WHERE archived = 0 AND amount > 0";
    $query = mysqli_query($con, $sql);
    $i = 1;

    if (mysqli_num_rows($query) > 0) {
        while ($fetch = mysqli_fetch_assoc($query)) {
            echo "
            <tr>
                <td>".$i."</td>
                <td>".htmlspecialchars($fetch["name"])."</td>
                <td>".htmlspecialchars($fetch["amount"])."</td>
                <td>".htmlspecialchars($fetch["date"])."</td>
                <td>".htmlspecialchars($fetch["status"])."</td>
                <td>";

            // Disable buttons if status is "Approved"
            $disabled = $fetch['status'] === 'Approved' ? 'disabled' : '';

            echo "
                <button type='button' data-toggle='modal' data-target='#modal-edit-cash-".$fetch['id']."' class='btn btn-warning edit' id='".$fetch['id']."' $disabled>
                    <i class='fa fa-edit'></i>
                </button>
                <button type='button' data-toggle='modal' data-target='#modal-delete-cash-".$fetch['id']."' class='btn btn-danger delete' id='".$fetch['id']."' $disabled>
                    <i class='fa fa-trash'></i>
                </button>";
            
            // Only show archive button if status is not Approved
            if ($fetch['status'] !== 'Approved') {
                echo "
                    <button type='button' data-toggle='modal' data-target='#modal-archive-cash-".$fetch['id']."' class='btn btn-secondary archive' id='".$fetch['id']."'>
                        <i class='fa fa-archive'></i>
                    </button>";
            }

            echo "</td>
            </tr>";

            // Edit Modal
            echo "<div class='modal fade' id='modal-edit-cash-".$fetch['id']."'>
                <div class='modal-dialog modal-lg'>
                    <div class='modal-content'>
                        <div class='modal-header bg-primary'>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>×</span></button>
                            <h4 class='modal-title'>Edit Cash Advance ID: " . $fetch['id'] . "</h4>
                        </div>
                        <div class='modal-body'>
                            <form method='post' action='function/function_crud.php'>
                                <input type='hidden' name='update_cash_advance' value='1'>
                                <input type='hidden' name='id' value='" . $fetch['id'] . "'>
                                <label>Name: </label> <input type='text' name='name' value='" . htmlspecialchars($fetch["name"]) . "' class='form-control' readonly><br>
                                <label>Amount: </label> <input type='text' name='amount' value='" . htmlspecialchars($fetch["amount"]) . "' class='form-control' readonly><br>
                                <label>Date: </label> <input type='date' name='date' value='" . htmlspecialchars($fetch["date"]) . "' class='form-control' readonly><br>
                                <label>Status: </label>
                                <select name='status' class='form-control' ".($fetch['status'] === 'Approved' ? 'disabled' : '').">
                                    <option value='Pending'" . ($fetch["status"] == 'Pending' ? ' selected' : '') . ">Pending</option>
                                    <option value='Approved'" . ($fetch["status"] == 'Approved' ? ' selected' : '') . ">Approved</option>
                                </select>
                                <br><br>
                        </div>
                        <div class='modal-footer'>
                            <button type='submit' class='btn btn-primary' ".($fetch['status'] === 'Approved' ? 'disabled' : '').">Update</button>
                            <button type='button' class='btn bg-maroon' data-dismiss='modal'>Close</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>";

            // Delete Modal
            echo "<div class='modal fade' id='modal-delete-cash-".$fetch['id']."'>
                <div class='modal-dialog modal-sm'>
                    <div class='modal-content'>
                        <div class='modal-header bg-danger'>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>×</span></button>
                            <h4 class='modal-title'>Delete Confirmation</h4>
                        </div>
                        <div class='modal-body'>
                            <center><h3>Are you sure you want to delete this advance?</h3></center>
                        </div>
                        <div class='modal-footer'>
                            <form method='post' action='function/function_crud.php'>
                                <input type='hidden' name='delete_cash_advance' value='1'>
                                <input type='hidden' name='id' value='".$fetch['id']."'>
                                <button type='submit' class='btn btn-danger' ".($fetch['status'] === 'Approved' ? 'disabled' : '').">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>";

            // Archive Modal
            echo "<div class='modal fade' id='modal-archive-cash-".$fetch['id']."'>
                <div class='modal-dialog modal-sm'>
                    <div class='modal-content'>
                        <div class='modal-header bg-secondary'>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>×</span></button>
                            <h4 class='modal-title'>Archive Confirmation</h4>
                        </div>
                        <div class='modal-body'>
                            <center><h3>Are you sure you want to archive this cash advance?</h3></center>
                        </div>
                        <div class='modal-footer'>
                            <form method='post' action='function/function_crud.php'>
                                <input type='hidden' name='archive_cash_advance' value='1'>
                                <input type='hidden' name='id' value='".$fetch['id']."'>
                                <button type='submit' class='btn btn-secondary' ".($fetch['status'] === 'Approved' ? 'disabled' : '').">Archive</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>";

            $i++;
        }
    }
}




function get_cash_advances_archive($con) {
    $sql = "SELECT * FROM cash_advances WHERE archived = 1";
    $query = mysqli_query($con, $sql);
    $i = 1;

    if (mysqli_num_rows($query) > 0) {
        while ($fetch = mysqli_fetch_assoc($query)) {
            echo "
            <tr>
                <td>".$i."</td>
                <td>".$fetch["name"]."</td>
                <td>".$fetch["amount"]."</td>
                <td>".$fetch["date"]."</td>
                <td>".$fetch["status"]."</td>
                <td>
                    <button type='button' data-toggle='modal' data-target='#modal-restore-cash-".$fetch['id']."' class='btn btn-success restore' id='".$fetch['id']."'>
                        <i class='fa fa-undo'></i>
                    </button>
                </td>
            </tr>";

            // Restore Modal
            echo "<div class='modal fade' id='modal-restore-cash-".$fetch['id']."'>
                <div class='modal-dialog modal-sm'>
                    <div class='modal-content'>
                        <div class='modal-header bg-success'>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>×</span></button>
                            <h4 class='modal-title'>Restore Confirmation</h4>
                        </div>
                        <div class='modal-body'>
                            <center><h3>Are you sure you want to restore this cash advance?</h3></center>
                        </div>
                        <div class='modal-footer'>
                            <form method='post' action='function/function_crud.php'>
                                <input type='hidden' name='restore_cash_advance' value='1'>
                                <input type='hidden' name='id' value='".$fetch['id']."'>
                                <button type='submit' class='btn btn-success'>Restore</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>";

            $i++;
        }
    }
}


//Manage Agents

function get_cottage($con) {
    // Select all relevant fields, including pumpboat_no
    $sql = "SELECT * FROM `cottage/hall`";
    $query = mysqli_query($con, $sql);
    $i = 1;

    if (mysqli_num_rows($query) > 0) {
        while ($fetch = mysqli_fetch_assoc($query)) {
            echo "
                <tr>
                    <td>".$i."</td>
                    <td>".$fetch['name']."</td>
                    <td>".$fetch['pumpboat_no']."</td> <!-- Display pumpboat_no here -->
                    <td>".$fetch['team']."</td>
                    <td>
                        <a href='?cottage-edit=".$fetch['id']."' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i></a>
                        <button type='button' data-toggle='modal' data-target='#modal-delete-".$fetch['id']."' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
                    </td>
                </tr>

                <div class='modal fade' id='modal-delete-".$fetch['id']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-sm' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Confirmation</h5>
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
        echo "<tr><td colspan='7'>No data available</td></tr>";
    }
}



function get_avail_cottage($con)

{
  $datetoday = date("Y-m-d");


  $sql3 = "SELECT *, `reservation`.id as res, `cottage/hall`.id as cid FROM

  reservation

  INNER JOIN `cottage/hall` ON `cottage/hall`.id = reservation.`cottage/hall_id`

  INNER JOIN `user` ON `user`.user_id = reservation.customer_id

  INNER JOIN user_type ON user_type.user_type_id = `user`.user_type_id 

  INNER JOIN payment ON payment.transaction_id = `reservation`.trans_no 

  WHERE reservation.date_reserve = '$datetoday' AND reservation.status = 'Fullypaid' OR reservation.status = 'Reserved'";

  $query3 = mysqli_query($con, $sql3);
  $arr = array();
  if (mysqli_num_rows($query3)>0) {

      while ($row = mysqli_fetch_assoc($query3)) {

          $get_me = $row["id"];
          array_push($arr, $get_me);
      }
      
  }else {
    $get_me = 0;
    array_push($arr, $get_me);
  }

   $arra = implode(",",$arr);
  //$sql = "SELECT * FROM `cottage/hall` WHERE `cottage/hall`.id IN (!$get_me)";
  //SELECT * FROM `cottage/hall` WHERE NOT `cottage/hall`.`id` IN (11,12)
  $sql = "SELECT * FROM `cottage/hall` WHERE NOT `cottage/hall`.`id` IN ($arra)";

  $query = mysqli_query($con, $sql);

  $i = 1;

  if (mysqli_num_rows($query) > 0) {

      while ($fetch = mysqli_fetch_assoc($query)) {

          echo "

                <tbody>

                    <tr>

                    <td><img src='function/".$fetch['img']."' alt='image' width='60px'></td>

                    <td>".$fetch['name']."</td>

                    <td>".$fetch['category']."</td>

                    <td>".$fetch['type']."</td>

                    <td>".$fetch['max_person']."</td>

                    <td>".$fetch['price']."</td>

                    </tr>

                </tbody>";


     

      }
    }
  



}


function get_n_avail_cottage($con)

{
  $datetoday = date("Y-m-d");

  $sql = "SELECT *, `reservation`.id as res FROM

  reservation

  INNER JOIN `cottage/hall` ON `cottage/hall`.id = reservation.`cottage/hall_id`

  INNER JOIN `user` ON `user`.user_id = reservation.customer_id

  INNER JOIN user_type ON user_type.user_type_id = `user`.user_type_id 

  INNER JOIN payment ON payment.transaction_id = `reservation`.trans_no 

  WHERE reservation.date_reserve = '$datetoday' AND reservation.status = 'Fullypaid' OR reservation.status = 'Reserved'";

  $query = mysqli_query($con, $sql);

  $i = 1;

  if (mysqli_num_rows($query) > 0) {

      while ($fetch = mysqli_fetch_assoc($query)) {

          echo "

                <tbody>

                    <tr>

                    <td><img src='function/".$fetch['img']."' alt='image' width='60px'></td>

                    <td>".$fetch['name']."</td>

                    <td>".$fetch['category']."</td>

                    <td>".$fetch['type']."</td>

                    <td>".$fetch['max_person']."</td>

                    <td>".$fetch['price']."</td>

                    </tr>

                </tbody>";


     

      }

  }else{

      echo "<tr>


      <td colspan='6'><center>No Reservation</center></td>


      </tr>";

  }



}

function get_feature($con)

{
  $sql = "SELECT * FROM `feature`";

  $query = mysqli_query($con, $sql);

  $i = 1;

  if (mysqli_num_rows($query) > 0) {

      while ($fetch = mysqli_fetch_assoc($query)) {

          echo "

                <tbody>

                    <tr>

                    <td>".$i."</td>

                    <td><img src='function/".$fetch['img']."' alt='image' width='60px'></td>

                  <!--  <td>".$fetch['name']."</td>

                    <td>".$fetch['desc']."</td>     !-->

           <td>
           <!-- <a href='?feature-edit=".$fetch['id']."' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i></a> !-->

                    <button type='button' data-toggle='modal' data-target='#modal-delete-".$fetch['id']."' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></td>

                    </tr>

                </tbody>";



        echo "<div class='modal fade in' id='modal-delete-".$fetch['id']."'>

                <div class='modal-dialog modal-sm'>

                <div class='modal-content'>

                    <div class='modal-header'>

                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>

                        <span aria-hidden='true'>×</span></button>

                    <h4 class='modal-title'>Confirmation</h4>

                    </div>

                    <div class='modal-body'>

                    <center><h3>Delete ".$fetch['name']."?</h3></center>

                    </div>

                    <div class='modal-footer'>

                    <button type='button' class='btn btn-default pull-left' data-dismiss='modal'>Close</button>

                    <a href='function/function_crud.php?feature-del=".$fetch['id']."' class='btn btn-danger'>Delete</a>

                    </div>

                </div>

                </div>

            </div>";

                $i=$i+1;

      }

  }else{

      echo "no data";

  }



}



function get_picture($con)

{

  $sql = "SELECT * FROM `picture`";

  $query = mysqli_query($con, $sql);

  $i = 1;

  if (mysqli_num_rows($query) > 0) {

      while ($fetch = mysqli_fetch_assoc($query)) {

          echo "

                <tbody>

                    <tr>

                    <td>".$i."</td>

                    <td><img src='function/".$fetch['img']."' alt='image' width='60px'></td>

                 <!--   <td>".$fetch['name']."</td> !-->

                 <!--   <td>".$fetch['des']."</td>  !-->

                    <td>
                  <!--  <a href='?picture-edit=".$fetch['id']."' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i></a> !-->

                    <button type='button' data-toggle='modal' data-target='#modal-delete-".$fetch['id']."' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
                    </td>

                    </tr>

                </tbody>";



        echo "<div class='modal fade in' id='modal-delete-".$fetch['id']."'>

                <div class='modal-dialog modal-sm'>

                <div class='modal-content'>

                    <div class='modal-header'>

                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>

                        <span aria-hidden='true'>×</span></button>

                    <h4 class='modal-title'>Confirmation</h4>

                    </div>

                    <div class='modal-body'>

                    <center><h3>Delete ".$fetch['name']."?</h3></center>

                    </div>

                    <div class='modal-footer'>

                    <button type='button' class='btn btn-default pull-left' data-dismiss='modal'>Close</button>

                    <a href='function/function_crud.php?picture-del=".$fetch['id']."' class='btn btn-danger'>Delete</a>

                    </div>

                </div>

                </div>

            </div>";

                $i=$i+1;

      }

  }else{

      echo "no data";

  }



}


function get_pending($con)

{

    $sql = "SELECT *, `reservation`.id as res FROM

    reservation

    INNER JOIN `cottage/hall` ON `cottage/hall`.id = reservation.`cottage/hall_id`

    INNER JOIN `user` ON `user`.user_id = reservation.customer_id

    INNER JOIN user_type ON user_type.user_type_id = `user`.user_type_id 

    INNER JOIN payment ON payment.transaction_id = `reservation`.trans_no 

    WHERE status = 'Pending' GROUP BY `trans_no`";

    $query = mysqli_query($con, $sql);

    

    $sql2 = "SELECT * FROM payment"; //query for payment

    $query2 = mysqli_query($con,$sql2);

    $fetch2 = mysqli_fetch_assoc($query2);

    $i = 1;

    if (mysqli_num_rows($query) > 0) {

        while ($fetch = mysqli_fetch_assoc($query)){

            echo "

                 <tbody>

                  <tr>

                   <td>".$i."</td>

                   <td>".$fetch["trans_no"]."</td>

                   <td>".$fetch["fname"]." ".$fetch["lname"]."</td> 

                   <td><span class='text-blue'>".$fetch["ref_no"]."</span></td>

                   <td><span class='badge bg-orange'>".$fetch["status"]."</span></td>

                   <td>".date("M d, Y", strtotime($fetch["date_created"]))."</td>

                   <td>

                   <button type='button' data-toggle='modal' data-target='#modal-view-".$fetch['res']."' class='btn btn-success view' id='".$fetch['trans_no']."'>View</button>

                   </td>

                  </tr>

                 </tbody>";

                 $i=$i+1;



                

                        echo "<div class='modal fade in' id='modal-view-".$fetch['res']."'>

                        <div class='modal-dialog modal-lg'>

                        <div class='modal-content'>

                            <div class='modal-header bg-green'>

                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>

                                <span aria-hidden='true'>×</span></button>

                            <h4 class='modal-title'>Transaction #: ".$fetch['trans_no']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gcash ref no. ".$fetch['ref_no']."</h4>

                            </div>

                            <div class='modal-body'>

                            <label>Customer Name: </label> ".ucfirst($fetch["fname"])." ".ucfirst($fetch["lname"])."<br>

                            <label>Customer Address: </label> ".ucfirst($fetch["address"])."<br>

                            <label>Customer Contact #: </label> ".ucfirst($fetch["contact_no"])."<br><br>

                             <div id='view-reserve'></div>

                            </div>

                            <div class='modal-footer'>


                            <a href='#' class='btn btn-success' data-toggle='modal' data-target='#modalconfirm".$fetch['trans_no']."'>Confirm</a>

                            <a href='#' class='btn btn-danger' data-toggle='modal' data-target='#modalcancel".$fetch['trans_no']."'>Cancel</a>

                            <a href='function/reciept.php?res-id=".$fetch['trans_no']."' target='_blank' class='btn btn-primary'><i class='fa fa-print'></i> Reciept</a></td>

                            <button type='button' class='btn bg-maroon' data-dismiss='modal'>Close</button>

                            </div>

                        </div>

                        </div>

                    </div>";


                    echo  "<div class='modal fade in' id='modalcancel".$fetch['trans_no']."'>
          <div class='modal-dialog modal-sm'>
            <div class='modal-content'>
              <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>×</span></button>
                <h4 class='modal-title'>Confirmation</h4>
              </div>
              <div class='modal-body'>
                <center><h3>Are you sure?</h3></center>
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-default pull-left' data-dismiss='modal'>Close</button>
                <a href='function/function_crud.php?res-id-cancel=".$fetch['trans_no']."' class='btn btn-success'>Yes</a>
              </div>
            </div>
          </div> 
        </div>";

        echo  "<div class='modal fade in' id='modalconfirm".$fetch['trans_no']."'>
          <div class='modal-dialog modal-sm'>
            <div class='modal-content'>
              <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>×</span></button>
                <h4 class='modal-title'>Confirmation</h4>
              </div>
              <div class='modal-body'>
                <center><h3>Are you sure?</h3></center>
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-default pull-left' data-dismiss='modal'>Close</button>
                <a href='function/function_crud.php?res-for-confirm-id=".$fetch['trans_no']."&no=".$fetch['contact_no']."' class='btn btn-success'>Confirm</a>
              </div>
            </div>
          </div> 
        </div>";

                

        }

    }else {

        //echo "no result";

    }

}




function get_reserved2($con)

{

    $sql = "SELECT *, `reservation`.id as res FROM

    reservation

    INNER JOIN `cottage/hall` ON `cottage/hall`.id = reservation.`cottage/hall_id`

    INNER JOIN `user` ON `user`.user_id = reservation.customer_id
    
    INNER JOIN user_type ON user_type.user_type_id = `user`.user_type_id 

    WHERE status = 'Reserved' GROUP BY `trans_no`";

    $query = mysqli_query($con, $sql);

    

    $sql2 = "SELECT * FROM payment"; //query for payment

    $query2 = mysqli_query($con,$sql2);

    $fetch2 = mysqli_fetch_assoc($query2);

    $i = 1;

    if (mysqli_num_rows($query) > 0) {

        while ($fetch = mysqli_fetch_assoc($query)){

            echo "

                 <tbody>

                  <tr>

                   <td>".$i."</td>

                   <td>".$fetch["trans_no"]."</td>

                   <td>".$fetch["fname"]." ".$fetch["lname"]."</td> 

                   <td><span class='badge bg-orange'>".$fetch["status"]."</span></td>

                   <td>".date("M d, Y", strtotime($fetch["date_created"]))."</td>

                   <td>

                   <button type='button' data-toggle='modal' data-target='#modal-view-".$fetch['res']."' class='btn btn-success view' id='".$fetch['trans_no']."'>View</button>

                   </td>

                  </tr>

                 </tbody>";

                 $i=$i+1;



                

                        echo "<div class='modal fade in hideme' id='modal-view-".$fetch['res']."'>

                        <div class='modal-dialog modal-lg'>

                        <div class='modal-content'>

                            <div class='modal-header bg-green'>

                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>

                                <span aria-hidden='true'>×</span></button>

                            <h4 class='modal-title'>Transaction #: ".$fetch['trans_no']."</h4>

                            </div>

                            <div class='modal-body'>

                            <label>Customer Name: </label> ".ucfirst($fetch["fname"])." ".ucfirst($fetch["lname"])."<br>

                            <label>Customer Address: </label> ".ucfirst($fetch["address"])."<br><br>

                             <div id='view-reserve'></div>

                            </div>

                            <div class='modal-footer'>


                            <button type='button' class='btn btn-success btnhide' data-toggle='modal' data-target='#modalpaid'".$fetch['trans_no']."'>Paid Balance</a>

                            <button type='button' class='btn bg-maroon' data-dismiss='modal'>Close</button>

                            </div>

                        </div>

                        </div>

                    </div>";


      echo  "<div class='modal fade in' id='modalpaid'".$fetch['trans_no']."'>
          <div class='modal-dialog modal-sm'>
            <div class='modal-content'>
              <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>×</span></button>
                <h4 class='modal-title'>Confirmation</h4>
              </div>
              <div class='modal-body'>
                <center><h3>Are you sure?</h3></center>
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-default pull-left' data-dismiss='modal'>Close</button>
                <a href='function/function_crud.php?res-id=".$fetch['trans_no']."' class='btn btn-success'>Paid Balance</a>
              </div>
            </div>
          </div> 
        </div>";
        }

    }else {

        //echo "no result";

    }

}





function get_confirm($con)

{

    $sql = "SELECT *, `reservation`.id as res FROM

    reservation

    INNER JOIN `cottage/hall` ON `cottage/hall`.id = reservation.`cottage/hall_id`

    INNER JOIN `user` ON `user`.user_id = reservation.customer_id

    INNER JOIN user_type ON user_type.user_type_id = `user`.user_type_id 

    WHERE status = 'Fullypaid' GROUP BY `trans_no`";

    $query = mysqli_query($con, $sql);

    

    $sql2 = "SELECT * FROM payment"; //query for payment

    $query2 = mysqli_query($con,$sql2);

    $fetch2 = mysqli_fetch_assoc($query2);

    $i = 1;

    if (mysqli_num_rows($query) > 0) {

        while ($fetch = mysqli_fetch_assoc($query)){

            echo "

                 <tbody>

                  <tr>

                   <td>".$i."</td>

                   <td>".$fetch["trans_no"]."</td>

                   <td>".$fetch["fname"]." ".$fetch["lname"]."</td> 

                   <td><span class='badge bg-orange'>".$fetch["status"]."</span></td>

                   <td>".date("M d, Y", strtotime($fetch["date_created"]))."</td>

                   

                  <td>

                   <buton type='button' data-toggle='modal' data-target='#modal-view-".$fetch['res']."' class='btn btn-success view' id='".$fetch['trans_no']."'>View</buton></td>

                  </tr>

                 </tbody>";

                 $i=$i+1;



            echo "<div class='modal fade in' id='modal-view-".$fetch['res']."'>

                <div class='modal-dialog modal-lg'>

                <div class='modal-content'>

                    <div class='modal-header bg-green'>

                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>

                        <span aria-hidden='true'>×</span></button>

                    <h4 class='modal-title'>Transaction #: ".$fetch['trans_no']."</h4>

                    </div>

                    <div class='modal-body'>

                    <label>Customer Name: </label> ".ucfirst($fetch["fname"])." ".ucfirst($fetch["lname"])."<br>

                    <label>Customer Address: </label> ".ucfirst($fetch["address"])."<br><br>

                     <div id='view-reserve'></div>

                    </div>

                    <div class='modal-footer'>

                    

                    <a href='function/recieptPaid.php?res-id=".$fetch['trans_no']."' target='_blank' class='btn btn-primary'><i class='fa fa-print'></i> Reciept</a>

                    <button type='button' class='btn bg-maroon' data-dismiss='modal'>Close</button>

                    </div>

                </div>

                </div>

            </div>";

                

        }

    }else {

        //echo "no result";

    }

}



function get_cancld($con)

{

    $sql = "SELECT *, `reservation`.id as res FROM

    reservation

    INNER JOIN `cottage/hall` ON `cottage/hall`.id = reservation.`cottage/hall_id`

    INNER JOIN `user` ON `user`.user_id = reservation.customer_id

    INNER JOIN user_type ON user_type.user_type_id = `user`.user_type_id 

    WHERE status = 'Canceled' GROUP BY `trans_no`";

    $query = mysqli_query($con, $sql);

    

    $sql2 = "SELECT * FROM payment"; //query for payment

    $query2 = mysqli_query($con,$sql2);

    $fetch2 = mysqli_fetch_assoc($query2);

    $i = 1;

    if (mysqli_num_rows($query) > 0) {

        while ($fetch = mysqli_fetch_assoc($query)){

            echo "

                 <tbody>

                  <tr>

                   <td>".$i."</td>

                   <td>".$fetch["trans_no"]."</td>

                   <td>".$fetch["fname"]." ".$fetch["lname"]."</td> 

                   <td><span class='badge bg-orange'>".$fetch["status"]."</span></td>

                   <td>

                   <buton type='button' data-toggle='modal' data-target='#modal-view-".$fetch['res']."' class='btn btn-success view' id='".$fetch['trans_no']."'>View</buton>

                  </tr>

                 </tbody>";

                 $i=$i+1;



            echo "<div class='modal fade in' id='modal-view-".$fetch['res']."'>

                <div class='modal-dialog modal-lg'>

                <div class='modal-content'>

                    <div class='modal-header bg-green'>

                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>

                        <span aria-hidden='true'>×</span></button>

                    <h4 class='modal-title'>Transaction #: ".$fetch['trans_no']."</h4>

                    </div>

                    <div class='modal-body'>

                    <label>Customer Name: </label> ".ucfirst($fetch["fname"])." ".ucfirst($fetch["lname"])."<br>

                    <label>Customer Address: </label> ".ucfirst($fetch["address"])."<br><br>

                     <div id='view-reserve'></div>

                    </div>

                    <div class='modal-footer'>

                    

                

                    

                    <button type='button' class='btn bg-maroon' data-dismiss='modal'>Close</button>

                    </div>

                </div>

                </div>

            </div>";

                

        }

    }else {

        //echo "no result";

    }

}

// Manage Payment 
function manage_payment($con) {
    $sql = "SELECT * FROM cash_advances";
    $result = mysqli_query($con, $sql);
    return $result;
}







 function get_reserved($con)

{

    $sql = "SELECT *, `reservation`.id as rec_id FROM

    reservation

    INNER JOIN `cottage/hall` ON `cottage/hall`.id = reservation.`cottage/hall_id`

    INNER JOIN `user` ON `user`.user_id = reservation.customer_id

    INNER JOIN user_type ON user_type.user_type_id = `user`.user_type_id WHERE status = 'Reserved'";

    $query = mysqli_query($con, $sql);

    $i = 1;

    if (mysqli_num_rows($query) > 0) {

        while ($fetch = mysqli_fetch_assoc($query)){

            echo "

                 <tbody>

                  <tr>

                   <td>".$i."</td>

                   <td>".$fetch["trans_no"]."</td>

                   <td>".date('F d, Y', strtotime($fetch["date_reserve"]))."</td>

                   <td>".$fetch["fname"]." ".$fetch["lname"]."</td>

                   <td>".$fetch["name"]."</td>

                   <td class='text-primary'>".number_format($fetch['downpayment'])."</td>

                   <td class='text-primary'>".number_format($fetch['balance'])."</td>

                   <td class='text-primary'>".number_format($fetch["price"])."</td>

                   <td><span class='badge bg-green'>".$fetch["status"]."</span></td>

                   <td width='130px'>

                   <a href='function/reciept.php?res-id=".$fetch['rec_id']."' target='_blank' class='btn btn-primary btn-xs'><i class='fa fa-print'></i> Reciept</a></td>

                  </tr>

                 </tbody>";

                 $i=$i+1;

        }

    }else {

        echo "no result";

    }

}


function get_canceled($con)

{

    $sql = "SELECT * FROM

    reservation

    INNER JOIN `cottage/hall` ON `cottage/hall`.id = reservation.`cottage/hall_id`

    INNER JOIN `user` ON `user`.user_id = reservation.customer_id

    INNER JOIN user_type ON user_type.user_type_id = `user`.user_type_id WHERE status = 'Canceled'";

    $query = mysqli_query($con, $sql);

    $i = 1;

    if (mysqli_num_rows($query) > 0) {

        while ($fetch = mysqli_fetch_assoc($query)){

            echo "

                 <tbody>

                  <tr>

                   <td>".$i."</td>

                   <td>".$fetch["trans_no"]."</td>

                   <td>".date('F d, Y', strtotime($fetch["date_reserve"]))."</td>

                   <td>".$fetch["fname"]." ".$fetch["lname"]."</td>

                   <td>".$fetch["name"]."</td>

                   <td class='text-primary'>".number_format($fetch['downpayment'],2)."</td>

                   <td class='text-primary'>".number_format($fetch['balance'],2)."</td>

                   <td class='text-primary'>".number_format($fetch["price"],2)."</td>

                   <td><span class='badge bg-red'>".$fetch["status"]."</span></td>

                  </tr>

                 </tbody>";

                 $i=$i+1;

        }

    }else {

        echo "no result";

    }

}



function get_users($con) {
    $sql = "SELECT `user`.*, user_type.user_type_name
            FROM `user`
            INNER JOIN user_type ON user_type.user_type_id = `user`.user_type_id
            WHERE `user`.user_type_id != 1 AND `user`.user_type_id != 2";

    $query = mysqli_query($con, $sql);
    $i = 1;

    if (mysqli_num_rows($query) > 0) {
        while ($fetch = mysqli_fetch_assoc($query)) {
            $passwordFieldId = "password-" . $fetch['user_id'];

            echo "<tr>
                    <td>".$i."</td>
                    <td>".$fetch['fname']."</td>
                    <td>".$fetch['mname']."</td>
                    <td>".$fetch['lname']."</td>
                    <td>".$fetch['address']."</td>
                    <td>".$fetch['email']."</td>
                    <td>".$fetch['contact_no']."</td>
                    <td>".$fetch['person_to_contact']."</td>
                    <td>".$fetch['user_type_name']."</td>
                    <td>".$fetch['uname']."</td>
              <!--      <td>
                        <input type='password' id='".$passwordFieldId."' value='".$fetch['pass']."' readonly style='border: none; background: transparent;'>
                        <i id='eye-icon-".$passwordFieldId."' class='fa fa-eye' style='cursor: pointer;' onclick='togglePasswordVisibility(\"".$passwordFieldId."\")'></i>
                    </td> !-->
                    <td>
                        <a href='?users-edit=".$fetch['user_id']."' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i></a>
                        <button type='button' data-toggle='modal' data-target='#user-".$fetch['user_id']."' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
                    </td>
                </tr>";

            // Modal for delete confirmation
            echo "<div class='modal fade' id='user-".$fetch['user_id']."'>
                    <div class='modal-dialog modal-sm'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span></button>
                                <h4 class='modal-title'>Delete Confirmation</h4>
                            </div>
                            <div class='modal-body'>
                                <center><h3>Are you sure you want to delete ".$fetch['fname']." ".$fetch['lname']."?</h3></center>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-default pull-left' data-dismiss='modal'>Cancel</button>
                                <a href='function/function_crud.php?user-del=".$fetch['user_id']."' class='btn btn-danger'>Delete</a>
                            </div>
                        </div>
                    </div>
                </div>";

            $i++;
        }
    }
}





function get_feedback($con)

{

  $sql = "SELECT * FROM `feedback`";

  $query = mysqli_query($con, $sql);

  $i = 1;

  if (mysqli_num_rows($query) > 0) {

      while ($fetch = mysqli_fetch_assoc($query)) {

          echo "

                <tbody>

                    <tr>

                    <td>".$i."</td>

                    <td>".$fetch['name']."</td>

                    <td>".$fetch['description']."</td>

                    <td><button type='button' data-toggle='modal' data-target='#modal-delete-".$fetch['feedback_id']."' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></td>

                    </tr>

                </tbody>";



        echo "<div class='modal fade in' id='modal-delete-".$fetch['feedback_id']."'>

                <div class='modal-dialog modal-sm'>

                <div class='modal-content'>

                    <div class='modal-header'>

                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>

                        <span aria-hidden='true'>×</span></button>

                    <h4 class='modal-title'>Confirmation</h4>

                    </div>

                    <div class='modal-body'>

                    <center><h3>Are you sure</center>

                    </div>

                    <div class='modal-footer'>

                    <button type='button' class='btn btn-default pull-left' data-dismiss='modal'>Close</button>

                    <a href='function/function_crud.php?feedback-del=".$fetch['feedback_id']."' class='btn btn-danger'>Delete</a>

                    </div>

                </div>

                </div>

            </div>";

                $i=$i+1;

      }

  }else{

      echo "no data";

  }



}



function count_pumpboats($con) {
    // Prepare the SQL query
    $sql = "SELECT COUNT(*) AS total FROM `pumpboats`";
    $stmt = $con->prepare($sql);
    
    if ($stmt === false) {
        die("Prepare failed: " . $con->error);
    }
    
    // Execute the statement
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    
    // Bind the result
    $stmt->bind_result($total);
    
    // Fetch the result
    if (!$stmt->fetch()) {
        die("Fetch failed: " . $stmt->error);
    }
    
    // Close the statement
    $stmt->close();
    
    // Output the total
    echo $total;
}

function count_me2($con){
    $sql = "SELECT SUM(amount) AS total_sales FROM invoices";
    $query = mysqli_query($con, $sql);
    
    if ($query) {
        $result = mysqli_fetch_assoc($query);
        $total_sales = $result['total_sales'];

        // Check if total_sales is not null
        if ($total_sales !== null) {
            // Format the total sales with commas and two decimal places
            echo '₱' . number_format($total_sales, 2);
        } else {
            // If total_sales is null, display ₱0.00
            echo '₱0.00';
        }
    } else {
        // Output the error message if the query failed
        echo "Error: " . mysqli_error($con);
    }
}



function count_me0($con){
    $sql = "SELECT COUNT(*) AS user_count FROM user WHERE user_type_id = 3";
    $query = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($query);
    $user_count = $result['user_count'];
    echo $user_count;
}

function total_teams($con) {
    $sql = "SELECT COUNT(*) AS total FROM pumpboats WHERE team IS NOT NULL";
    $query = mysqli_query($con, $sql);
    
    if ($query) {
        $result = mysqli_fetch_assoc($query);
        $total_teams = $result['total'];
        echo $total_teams;
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

function unpaid_total($con) {
    $sql = "SELECT IFNULL(SUM(amount), 0) AS total FROM cash_advances WHERE amount IS NOT NULL AND status != 'pending'";
    $query = mysqli_query($con, $sql);
    if ($query) {
        $result = mysqli_fetch_assoc($query);
        $unpaid_total = $result['total'];
        echo '₱' . number_format($unpaid_total, 2);
    } else {
        echo "Error: " . mysqli_error($con);
    }
}


function count_totalagents($con) {
    $sql = "SELECT SUM(total_amount) AS total_sales FROM receipt_records";
    $query = mysqli_query($con, $sql);
    
    if ($query) {
        $result = mysqli_fetch_assoc($query);
        $total_sales = $result['total_sales'];

        // Check if total_sales is not null
        if ($total_sales !== null) {
            // Format the total sales with commas and two decimal places
            echo '₱' . number_format($total_sales, 2);
        } else {
            // If total_sales is null, display ₱0.00
            echo '₱0.00';
        }
    } else {
        // Output the error message if the query failed
        echo "Error: " . mysqli_error($con);
    }
}





