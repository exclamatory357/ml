<?php

session_start();

include "../../config/db.php";



//payment manage
// Process Payment
// Process Payment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['process_payment'])) {
    // Input variables
    $advance_id = $_POST['advance_id'];
    $payment_amount = $_POST['payment_amount'];
    $user_id = $_POST['user_id'];

    // Input validation - Check if all inputs are numeric
    if (!is_numeric($advance_id) || !is_numeric($payment_amount) || !is_numeric($user_id)) {
        $_SESSION["notify"] = "invalid-input";
        header("location: ../?manage_payment");
        exit;
    }

    // Typecasting after validation
    $advance_id = intval($advance_id);
    $payment_amount = floatval($payment_amount);
    $user_id = intval($user_id);

    // Prepared statement to get the current amount and original amount from cash_advances table
    $sql_get_amount = "SELECT amount, original_amount, total_paid FROM cash_advances WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql_get_amount);
    mysqli_stmt_bind_param($stmt, "i", $advance_id);
    mysqli_stmt_execute($stmt);
    $result_get_amount = mysqli_stmt_get_result($stmt);

    if (!$result_get_amount) {
        die('Error fetching cash advances data: ' . mysqli_error($con));
    }

    if ($result_get_amount && mysqli_num_rows($result_get_amount) > 0) {
        $row = mysqli_fetch_assoc($result_get_amount);
        $current_amount = $row['amount'];
        $original_amount = $row['original_amount'];
        $total_paid = $row['total_paid'];

        // Ensure the payment amount is valid
        if ($payment_amount > $current_amount) {
            $_SESSION["notify"] = "invalid-amount";
            header("location: ../?manage_payment");
            exit;
        }

        // Ensure original_amount is set if it's not already
        if (is_null($original_amount) || $original_amount == 0) {
            $original_amount = $current_amount;
            $sql_set_original = "UPDATE cash_advances SET original_amount = ? WHERE id = ?";
            $stmt_update = mysqli_prepare($con, $sql_set_original);
            mysqli_stmt_bind_param($stmt_update, "di", $original_amount, $advance_id);
            if (!mysqli_stmt_execute($stmt_update)) {
                die('Error updating original amount: ' . mysqli_error($con));
            }
        }

        // Update cash_advances table by deducting the payment amount and adding to total paid
        $sql1 = "UPDATE cash_advances SET amount = amount - ?, total_paid = total_paid + ? WHERE id = ?";
        $stmt_update_amount = mysqli_prepare($con, $sql1);
        mysqli_stmt_bind_param($stmt_update_amount, "ddi", $payment_amount, $payment_amount, $advance_id);
        if (!mysqli_stmt_execute($stmt_update_amount)) {
            die('Error updating cash advances: ' . mysqli_error($con));
        }

        // Insert the payment into invoices table
        $remaining_amount = $current_amount - $payment_amount;
        $description = 'Payment Processed';
        $status = 'Paid';

        $sql2 = "INSERT INTO invoices (user_id, date_issued, amount, original_amount, remaining_amount, status, description) 
                 VALUES (?, NOW(), ?, ?, ?, ?, ?)";
        $stmt_insert_invoice = mysqli_prepare($con, $sql2);
        mysqli_stmt_bind_param($stmt_insert_invoice, "idddss", $user_id, $payment_amount, $original_amount, $remaining_amount, $status, $description);
        if (!mysqli_stmt_execute($stmt_insert_invoice)) {
            die('Error inserting into invoices: ' . mysqli_error($con));
        }

        // Generate receipt PDF and prompt user to print
        generateReceiptPDFFunction($advance_id, $user_id);

        $_SESSION["notify"] = "success-payment";
        header("location: ../?manage_payment");
        exit;
    } else {
        $_SESSION["notify"] = "no-record-found";
        header("location: ../?manage_payment");
        exit;
    }
}

// Function to generate receipt PDF
function generateReceiptPDFFunction($advance_id, $user_id) {
    global $con;
    require('../../plugins/fpdf/fpdf.php');

    // Fetch payment details
    $sql = "SELECT cash_advances.*, user.fname, user.lname FROM cash_advances 
            INNER JOIN user ON cash_advances.user_id = user.user_id WHERE cash_advances.id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $advance_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        die('Error fetching payment details: ' . mysqli_error($con));
    }
    $row = mysqli_fetch_assoc($result);

    $user_name = $row['fname'] . ' ' . $row['lname'];

    // Fetch the most recent payment
    $sql_recent_payment = "SELECT invoice_id, amount AS payment_amount, date_issued AS payment_date, original_amount, remaining_amount FROM invoices WHERE user_id = ? ORDER BY date_issued DESC LIMIT 1";
    $stmt_recent_payment = mysqli_prepare($con, $sql_recent_payment);
    mysqli_stmt_bind_param($stmt_recent_payment, "i", $user_id);
    mysqli_stmt_execute($stmt_recent_payment);
    $result_recent_payment = mysqli_stmt_get_result($stmt_recent_payment);
    if (!$result_recent_payment) {
        die('Error fetching recent payment: ' . mysqli_error($con));
    }
    $recent_payment = mysqli_fetch_assoc($result_recent_payment);
    $invoice_id = $recent_payment['invoice_id'];
    $paid_amount = $recent_payment['payment_amount'];
    $original_amount = $recent_payment['original_amount'];
    $remaining_amount = $recent_payment['remaining_amount'];

    $pdf = new FPDF('P', 'mm', 'LETTER');
    $pdf->SetTitle('Fully Paid Receipt', true);
    $pdf->AddPage();

    // Title header
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetX(60);
    $pdf->Cell(90, 13, 'Fully Paid Receipt', '', 0, 'C');
    $pdf->Ln();
    $pdf->SetFont('Arial', '', 9);
    $pdf->Ln();

    // Style the receipt
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(0, 51, 102);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(190, 10, 'DanRose Fishing Management System', 0, 1, 'C', true);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(190, 5, 'Receipt for Cash Advance', 0, 1, 'C');
    $pdf->Cell(190, 5, 'FROM: ' . date('Y-m-d') . ' TO: ' . date('Y-m-d'), 0, 1, 'C');
    $pdf->Ln();

    // Add user name
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(190, 10, 'Agent Name: ' . $user_name, 0, 1, 'C');
    $pdf->Ln();

    // Set colors for the table headers
    $pdf->SetFillColor(100, 100, 255); // Light blue
    $pdf->SetTextColor(255, 255, 255); // White text
    $pdf->SetDrawColor(0, 0, 0); // Black border
    $pdf->SetLineWidth(0.5); // Line width

    // Receipt details with table headers
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 10, 'Transaction ID', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Original Amount', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Pay', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Remaining Amount', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Status', 1, 1, 'C', true);

    // Add data to the table
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetFillColor(245, 245, 245); // Light gray for rows
    $pdf->SetTextColor(0, 0, 0); // Black text
    $pdf->Cell(40, 10, $invoice_id, 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Pesos ' . number_format($original_amount, 2), 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Pesos ' . number_format($paid_amount, 2), 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Pesos ' . number_format($remaining_amount, 2), 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Paid', 1, 1, 'C', true);
    $pdf->Ln();

    // Output the PDF to browser for print
    $pdf->Output('I', 'Fully_Paid_Receipt.pdf');
    exit;
}

















////////////////////////////////////////OPSSSSSS SAKTO/////////////////////////
// Archive Cash Advance
if (isset($_POST['archive_cash_advance'])) {
    $id = $_POST['id'];
    $sql = "UPDATE cash_advances SET archived = 1 WHERE id = $id";
    if (mysqli_query($con, $sql)) {
        // Redirect or display success message
        header('Location: ../?reserved2'); // Update with your actual redirect page
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

// Restore Cash Advance
if (isset($_POST['restore_cash_advance'])) {
    $id = $_POST['id'];
    $sql = "UPDATE cash_advances SET archived = 0 WHERE id = $id";
    if (mysqli_query($con, $sql)) {
        // Redirect or display success message
        header('Location: ../?reserved2'); // Update with your actual redirect page
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

// Update Maintenance Request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_maintenance_request'])) {
    $id = $_POST['id'];
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $request_date = $_POST['request_date'];
    $status = $_POST['status'];
    $admin_comment = $_POST['admin_comment'];
    $admin_approval = $_POST['admin_approval'];

    $sql = "UPDATE maintenance_requests 
            SET item_name = '$item_name', description = '$description', request_date = '$request_date', status = '$status', admin_comment = '$admin_comment', admin_approval = '$admin_approval' 
            WHERE id = '$id'";

    if (mysqli_query($con, $sql)) {
        $_SESSION["notify"] = "success-update";
        header("location: ../?reserved2");
    } else {
        $_SESSION["notify"] = "failed-update";
        error_log("Failed to update maintenance request: " . mysqli_error($con));
        header("location: ../?reserved2");
    }
}

// Delete Maintenance Request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_maintenance_request'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM maintenance_requests WHERE id = '$id'";

    if (mysqli_query($con, $sql)) {
        $_SESSION["notify"] = "success-delete";
        header("location: ../?reserved2");
    } else {
        $_SESSION["notify"] = "failed-delete";
        error_log("Failed to delete maintenance request: " . mysqli_error($con));
        header("location: ../?reserved2");
    }
}

// Update Cash Advance
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cash_advance'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    $sql = "UPDATE cash_advances 
            SET name = '$name', amount = '$amount', date = '$date', status = '$status' 
            WHERE id = '$id'";

    if (mysqli_query($con, $sql)) {
        $_SESSION["notify"] = "success-update";
        header("location: ../?reserved2");
    } else {
        $_SESSION["notify"] = "failed-update";
        error_log("Failed to update cash advance: " . mysqli_error($con));
        header("location: ../?reserved2");
    }
}

// Delete Cash Advance
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_cash_advance'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM cash_advances WHERE id = '$id'";

    if (mysqli_query($con, $sql)) {
        $_SESSION["notify"] = "success-delete";
        header("location: ../?reserved2");
    } else {
        $_SESSION["notify"] = "failed-delete";
        error_log("Failed to delete cash advance: " . mysqli_error($con));
        header("location: ../?reserved2");
    }
}



// Add agent
if (isset($_POST["btn-cottage-add"])) {
    $name = $_POST["name"];
    $type = $_POST["type"];
    $cat = $_POST["category"];
    $team = $_POST["team"];  // New team field

    $sqlcott = "INSERT INTO `cottage/hall` (`name`, `type`, `category`, `team`) 
                VALUES ('$name', '$type', '$cat', '$team')";

    $query = mysqli_query($con, $sqlcott);

    if ($query) {
        $_SESSION["notify"] = "success-add";
        header("location: ../?cottage");
    } else {
        $_SESSION["notify"] = "failed-add";
        error_log("Failed to insert into cottage/hall: " . mysqli_error($con));
        header("location: ../?cottage");
    }
}


//delte cottage

if (isset($_GET["cottage-del"])) {

    $id = $_GET["cottage-del"];

    $sql = "DELETE FROM `cottage/hall` WHERE id = '$id'";

    $query = mysqli_query($con, $sql);

    if ($query) {

        $_SESSION["notify"] = "success-delete";

        header("location: ../?cottage");

    }else {

        echo "failed to delete";

    }

}

//delte feature

if (isset($_GET["feature-del"])) {

    $id = $_GET["feature-del"];

    $sql = "DELETE FROM `feature` WHERE id = '$id'";

    $query = mysqli_query($con, $sql);

    if ($query) {

        $_SESSION["notify"] = "success-delete";

        header("location: ../?features");

    }else {

        echo "failed to delete";

    }

}

//delte picture

if (isset($_GET["picture-del"])) {

    $id = $_GET["picture-del"];

    $sql = "DELETE FROM `picture` WHERE id = '$id'";

    $query = mysqli_query($con, $sql);

    if ($query) {

        $_SESSION["notify"] = "success-delete";

        header("location: ../?pictures");

    }else {

        echo "failed to delete";

    }

}



//add feature

if (isset($_POST["btn-feature-add"])) {

    $target_dir = "uploads/";

    $target_file = $target_dir . basename($_FILES["img"]["name"]);

    $name        = $_POST["name"];

    $desc         = $_POST["desc"];

    $sql = "INSERT INTO `feature`(`img`,`name`,`desc`) 

            VALUES('$target_file','$name','$desc')";

    $query = mysqli_query($con, $sql);



    if ($query) {

        move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);

        $_SESSION["notify"] = "success-add";

        header("location: ../?features");

    }else {

        $_SESSION["notify"] = "failed-add";

        header("location: ../?features");

    }

}



//add picture

if (isset($_POST["btn-picture-add"])) {

    $target_dir_pic = "uploads/";

    $target_file_pic = $target_dir_pic . basename($_FILES["img"]["name"]);



    $namepic         = $_POST["name"];

    $descpic         = $_POST["desc"];





    $sql2 = "INSERT INTO `picture`(`img`, `name`, `des`) VALUES ('$target_file_pic','$namepic','$descpic')"; 



    $query2 = mysqli_query($con, $sql2);



    if ($query2) {

        move_uploaded_file($_FILES["img"]["tmp_name"], $target_file_pic);

        $_SESSION["notify"] = "success-add";

        header("location: ../?pictures");

    }else {

        $_SESSION["notify"] = "failed-add";

        header("location: ../?pictures");

    }

}


//confirmation reservation
if (isset($_GET["res-for-confirm-id"])) {

    $res_id = $_GET["res-for-confirm-id"];
    $no     = $_GET["no"];
    

    

    $sqlGet = "SELECT * FROM payment WHERE transaction_id = '$res_id'";

    $queryGet = mysqli_query($con, $sqlGet);

    //$resPay = mysqli_fetch_assoc($queryGet);

    //$vaPay = $resPay["ammount_payment"] * 2;

    $sql="UPDATE `reservation` SET `status` = 'Reserved' WHERE `trans_no` = '$res_id'";

    $query = mysqli_query($con, $sql);

    if ($query) {
        //SMS HERE
        $text = 'Good day! this is DA Farm resort,  your reservation was successfully reserved. Thank you';

        $number = $no;
        
        
        
        exec('echo '.$text.' | gnokii --sendsms '.$number);

        $_SESSION["notify"] = "confirm";

        header("location: ../?pending");

    }else {

        $_SESSION["notify"] = "confirm-failed";

        header("location: ../?pending");

    }

}


//fullypaid reservation

if (isset($_GET["res-id"])) {

    $res_id = $_GET["res-id"];

    

    $sqlGet = "SELECT * FROM payment WHERE transaction_id = '$res_id'";

    $queryGet = mysqli_query($con, $sqlGet);

    $resPay = mysqli_fetch_assoc($queryGet);

    $vaPay = $resPay["ammount_payment"] * 2;





    $sql="UPDATE `reservation` SET `status` = 'Fullypaid' WHERE `trans_no` = '$res_id'";

    $query = mysqli_query($con, $sql);

    if ($query) {

        $sqlUpdate ="UPDATE `payment` SET ammount_payment = '$vaPay', `payment_status` = 'Fullypaid' WHERE `transaction_id` = '$res_id'";

        $queryUpdate = mysqli_query($con, $sqlUpdate);

        $_SESSION["notify"] = "paid";

        header("location: ../?reserved2");

    }else {

        $_SESSION["notify"] = "paid-failed";

        header("location: ../?reserved2");

    }

}

//cancel reservation

if (isset($_GET["res-id-cancel"])) {

    $res_id_cancel = $_GET["res-id-cancel"];

    $sql="UPDATE `reservation` SET `status` = 'Canceled' WHERE `trans_no` = '$res_id_cancel'";

    $query = mysqli_query($con, $sql);

    if ($query) {

        $_SESSION["notify"] = "cancel";

        header("location: ../?pending");

    }else {

        $_SESSION["notify"] = "cancel-failed";

        header("location: ../?pending");

    }

}





// adduser
if (isset($_POST["btnAddUser"])) {
    $fname = htmlspecialchars($_POST["fname"]);
    $mname = htmlspecialchars($_POST["mname"]);
    $lname = htmlspecialchars($_POST["lname"]);
    $email = htmlspecialchars($_POST["email"]);
    $contact_no = htmlspecialchars($_POST["contact_no"]);
    $person_to_contact = htmlspecialchars($_POST["person_to_contact"]);
    $uname = htmlspecialchars($_POST["uname"]);
    $pass  = htmlspecialchars($_POST["pass"]);
    $utype = htmlspecialchars($_POST["utype"]);
    $team  = htmlspecialchars($_POST["team"]); // if using the team input field
    $address = htmlspecialchars($_POST["address"]); // retrieve the address from the form

    // Hash the password using bcrypt
    $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);

    // Insert into the database with the hashed password
    $sql = "INSERT INTO `user`(`fname`, `mname`, `lname`, `email`, `contact_no`, `person_to_contact`, `uname`, `pass`, `user_type_id`, `team`, `address`) 
            VALUES ('$fname','$mname','$lname','$email','$contact_no','$person_to_contact','$uname','$hashed_pass','$utype','$team', '$address')";
    $query = mysqli_query($con, $sql);

    if ($query) {
        $_SESSION["notify"] = "success";
        header("location: ../?users");
        return;
    } else {
        $_SESSION["notify"] = "failed";
        header("location: ../?users");
        return;
    }
}








//delte user

if (isset($_GET["user-del"])) {

    $id = $_GET["user-del"];

    $sql = "DELETE FROM `user` WHERE user_id = '$id'";

    $query = mysqli_query($con, $sql);

    if ($query) {

        $_SESSION["notify"] = "success-delete";

        header("location: ../?users");

    }else {

        echo "failed to delete";

    }

}



//delte feedback

if (isset($_GET["feedback-del"])) {

    $id = $_GET["feedback-del"];

    $sql = "DELETE FROM `feedback` WHERE feedback_id = '$id'";

    $query = mysqli_query($con, $sql);

    if ($query) {

        $_SESSION["notify"] = "success-delete";

        header("location: ../?feedback");

    }else {

        echo "failed to delete";

    }

}

//edit agent

if (isset($_POST["btn-cottage-edit"])) {
    $id = $_POST["id"];
    $team  = $_POST["team"];
    $name = $_POST["name"];
    $type = $_POST["type"];
    $category = $_POST["category"];

    $sql = "UPDATE `cottage/hall` SET `team`='$team', `name`='$name', `type`='$type', `category`='$category' WHERE id = '$id'";
    $query = mysqli_query($con, $sql);

    if (!$query) {
        $_SESSION["notify"] = "failed";
        header("location: ../?cottage");
        return;
    }

    if ($query) {
        $_SESSION["notify"] = "success";
        header("location: ../?cottage");
        return;
    }
}

// update user
if (isset($_POST["updateuser"])) {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $fname = htmlspecialchars($_POST["fname"], ENT_QUOTES, 'UTF-8');
    $lname = htmlspecialchars($_POST["lname"], ENT_QUOTES, 'UTF-8');
    $uname = htmlspecialchars($_POST["uname"], ENT_QUOTES, 'UTF-8');
    $pass  = htmlspecialchars($_POST["pass"], ENT_QUOTES, 'UTF-8');
    $utype = htmlspecialchars($_POST["utype"], ENT_QUOTES, 'UTF-8');
    $team  = htmlspecialchars($_POST["team"], ENT_QUOTES, 'UTF-8'); // Uncomment if using
    $address = htmlspecialchars($_POST["address"], ENT_QUOTES, 'UTF-8'); // Sanitize address

    // Update the user information, including the address
    $sql = "UPDATE `user` SET 
            `fname`='$fname', 
            `lname`='$lname', 
            `uname`='$uname', 
            `pass`='$pass', 
            `user_type_id`='$utype', 
            `address`='$address' 
            WHERE user_id = '$id'";  // Include address in the SQL query

    $query = mysqli_query($con, $sql);

    if (!$query) {
        $_SESSION["notify"] = "failed";
        header("location: ../?users");
        return;
    }

    if ($query) {
        $_SESSION["notify"] = "success";
        header("location: ../?users");
        return;
    }
}


if (isset($_POST["btn-feature-edit"])) {
    $get_id = $_POST["id"];
    $name = $_POST["name"];
    $desc = $_POST["desc"];

    $sql = "UPDATE `feature` SET `name`='$name',`desc`='$desc' WHERE id = $get_id";
    $query = mysqli_query($con, $sql);

    if(!$query){
        $_SESSION["notify"] = "failed";
        header("location: ../?features");
        return;
    }
    if($query){
        $_SESSION["notify"] = "success";
        header("location: ../?features");
        return;
    }
}

if (isset($_POST["btn-picture-edit"])) {
    $get_id = $_POST["id"];
    $name = $_POST["name"];
    $desc = $_POST["desc"];

    $sql = "UPDATE `picture` SET `name`='$name',`des`='$desc' WHERE id = $get_id";
    $query = mysqli_query($con, $sql);

    if(!$query){
        $_SESSION["notify"] = "failed";
        header("location: ../?pictures");
        return;
    }
    if($query){
        $_SESSION["notify"] = "success";
        header("location: ../?pictures");
        return;
    }
}



        // Insert Operation PUMPBOATS
        if (isset($_POST["btn-pumpboat-add"])) {
            $license_no = $_POST["license_no"];
            $pumpboat_no = $_POST["pumpboat_no"];
            $type = $_POST["type"];
            $team = $_POST["team"];
        
            $sqlPumpboat = "INSERT INTO `pumpboats`(`license_no`, `pumpboat_no`, `type`, `team`) 
                            VALUES('$license_no','$pumpboat_no','$type','$team')";
            $query = mysqli_query($con, $sqlPumpboat);
        
            if ($query) {
                $_SESSION["notify"] = "success-add";
                header("location: ../?manage_pumpboats");
            } else {
                $_SESSION["notify"] = "failed-add";
                header("location: ../?manage_pumpboats");
            }
        }
        // /Insert Operation PUMPBOATS


        //  Delete Operation PUMPBOATS
        if (isset($_GET["pumpboat-del"])) {
            $id = $_GET["pumpboat-del"];
            $sql = "DELETE FROM `pumpboats` WHERE id = '$id'";
            $query = mysqli_query($con, $sql);
        
            if ($query) {
                $_SESSION["notify"] = "success-delete";
                header("location: ../?manage_pumpboats");
            } else {
                $_SESSION["notify"] = "failed-delete";
                header("location: ../?manage_pumpboats");
            }
        }
        // /Delete Operation PUMPBOATS
        
        // File Upload for Edit PUMPBOAT
        if (isset($_POST["btn-pumpboat-edit"])) {
            $id = $_POST["id"];
            $license_no = $_POST["license_no"];
            $pumpboat_no = $_POST["pumpboat_no"];
            $type = $_POST["type"];
            $status = $_POST["status"];
        
            $sql = "UPDATE `pumpboats` SET `license_no`='$license_no',`pumpboat_no`='$pumpboat_no',`type`='$type',`status`='$status' WHERE id = '$id'";
        
            $query = mysqli_query($con, $sql);
        
            if (!$query) {
                $_SESSION["notify"] = "failed";
                header("location: ../?manage_pumpboats");
                return;
            }
            if ($query) {
                $_SESSION["notify"] = "success";
                header("location: ../?manage_pumpboats");
                return;
            }
        }
        // /File Upload for Edit PUMPBOAT
        


