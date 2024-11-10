<?php

session_start();

include "../../config/db.php";

// SALE PRODUCT

// Handle Checkout Request
if (isset($_POST['checkout'])) {
    // Retrieve and sanitize form data
    $full_name = mysqli_real_escape_string($con, trim($_POST['full_name']));
    $address = mysqli_real_escape_string($con, trim($_POST['address']));
    $phone_number = mysqli_real_escape_string($con, trim($_POST['phone_number']));
    $amount = mysqli_real_escape_string($con, trim($_POST['amount'])); // Retrieve the amount field

    // Validate the amount to ensure it's numeric and greater than zero
    if (!is_numeric($amount) || $amount <= 0) {
        echo "Invalid amount. Please enter a valid number.";
        exit();
    }

    // Check if the cart is not empty
    if (!empty($_SESSION['cart'])) {
        // Calculate total price from cart items
        $total_price = array_reduce($_SESSION['cart'], function ($total, $item) {
            return $total + ($item['quantity'] * $item['price']);
        }, 0);

        // Calculate the change
        $change = $amount - $total_price;
        if ($change < 0) {
            echo "The amount given is less than the total amount due.";
            exit();
        }

        // Insert the sale record into sales_records
        $sql_sales = "INSERT INTO sales_records (buyer_name, sale_amount, sale_date) VALUES ('$full_name', '$total_price', NOW())";
        if (mysqli_query($con, $sql_sales)) {
            // Get the last inserted sale ID
            $sale_id = mysqli_insert_id($con);

            // Process each item in the cart
            foreach ($_SESSION['cart'] as $item) {
                $catch_item = mysqli_real_escape_string($con, $item['catch_item']);
                $quantity = (int) $item['quantity'];
                $price = (float) $item['price'];
                $total_amount = $quantity * $price;

                // Generate a unique receipt number
                $receipt_number = "RECEIPT-" . time() . rand(1000, 9999);

                // Insert receipt record including buyer details, item info, total amount, and the amount given
                $sql_receipt = "INSERT INTO receipt_records (sale_id, buyer_name, address, phone_number, receipt_number, amount, total_amount, payment_method, payment_date, remarks)
                                VALUES ('$sale_id', '$full_name', '$address', '$phone_number', '$receipt_number', '$amount', '$total_amount', 'Cash', NOW(), 'Purchase of $quantity kg of $catch_item')";
                if (!mysqli_query($con, $sql_receipt)) {
                    // Log error and terminate on failure
                    error_log("Failed to insert into receipt_records: " . mysqli_error($con));
                    echo "Failed to insert receipt: " . mysqli_error($con);
                    exit();
                }

                // Deduct the purchased quantity from catch_records_sell
                $sql_deduction = "UPDATE catch_records_sell 
                                  SET catch_kilo = catch_kilo - $quantity
                                  WHERE catch_item = '$catch_item' AND catch_kilo >= $quantity";
                if (!mysqli_query($con, $sql_deduction) || mysqli_affected_rows($con) == 0) {
                    // Log error if deduction fails due to insufficient stock or other issues
                    error_log("Failed to update catch_records_sell or insufficient stock for item $catch_item: " . mysqli_error($con));
                    echo "Failed to deduct catch quantity or insufficient stock: " . mysqli_error($con);
                    exit();
                }
            }

            // Clear the cart after successful checkout
            $_SESSION['cart'] = [];

            // Redirect to print_receipt.php with the sale_id and amount for automatic printing
            header("Location: ../view/print_receipt.php?sale_id=$sale_id&amount=$amount");
            exit();
        } else {
            // Log error if inserting the sales record fails
            $_SESSION['notify'] = "failed-checkout";
            error_log("Failed to insert into sales_records: " . mysqli_error($con));
            echo "Failed to insert sale: " . mysqli_error($con);
            exit();
        }
    } else {
        // Handle empty cart case
        $_SESSION['notify'] = "cart-empty";
        header("location: ../?page=manage_sell_product");
        exit();
    }
}



// /SELL PRODUCT

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

// Function to generate plain receipt PDF with a logo
function generateReceiptPDFFunction($advance_id, $user_id) {
    global $con;
    require('../../plugins/fpdf/fpdf.php');

    // Fetch payment details
    $sql = "SELECT cash_advances.*, user.fname, user.mname, user.lname FROM cash_advances 
            INNER JOIN user ON cash_advances.user_id = user.user_id WHERE cash_advances.id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $advance_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        die('Error fetching payment details: ' . mysqli_error($con));
    }
    $row = mysqli_fetch_assoc($result);

    $user_name = $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'];

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

    // Add Logo in the top-right corner
    $pdf->Image('uploads/icon.png', 160, 10, 30); // Adjust the path and position as needed

    // Title header
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 13, 'Receipt for Cash Advance', 0, 1, 'C');
    $pdf->Ln();

    // System Name Header
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'DanRose Fishing Management System', 0, 1, 'C');

    // Details Section
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, 'Date Issued: ' . date('Y-m-d', strtotime($recent_payment['payment_date'])), 0, 1, 'C');
    $pdf->Ln();
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Agent Name: ' . $user_name, 0, 1, 'C');
    $pdf->Ln();

    // Table Headers
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 10, 'Transaction ID', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Original Amount', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Pay', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Remaining Amount', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Status', 1, 1, 'C');

    // Table Content
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 10, $invoice_id, 1, 0, 'C');
    $pdf->Cell(40, 10, 'Pesos ' . number_format($original_amount, 2), 1, 0, 'C');
    $pdf->Cell(40, 10, 'Pesos ' . number_format($paid_amount, 2), 1, 0, 'C');
    $pdf->Cell(40, 10, 'Pesos ' . number_format($remaining_amount, 2), 1, 0, 'C');
    $pdf->Cell(30, 10, 'Paid', 1, 1, 'C');
    $pdf->Ln();

   // Signature Section
$pdf->Ln(20); // Space between table and signature line
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(140); // Move to the right
$pdf->Cell(60, 10, '_________________________', 0, 1, 'C'); // Signature line
$pdf->Cell(140); // Move to the right again to align the "Signature" label
$pdf->Cell(60, 5, 'Signature', 0, 1, 'C');

    // Output the PDF to browser for print
    $pdf->Output('I', 'Fully_Paid_Receipt.pdf');
    exit;
}


















////////////////////////////////////////OPSSSSSS SAKTO NA /////////////////////////


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
    $team = $_POST["team"];
    $pumpboat_no = $_POST["pumpboat_no"];  // Make sure this is collected

    $sqlcott = "INSERT INTO `cottage/hall` (`name`, `type`, `category`, `team`, `pumpboat_no`) 
                VALUES ('$name', '$type', '$cat', '$team', '$pumpboat_no')";  // Include pumpboat_no in the query

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

    // Check for duplicate email or username
    $check_sql = "SELECT * FROM `user` WHERE `email` = '$email' OR `uname` = '$uname'";
    $check_query = mysqli_query($con, $check_sql);

    if (mysqli_num_rows($check_query) > 0) {
        // Email or username already exists
        $_SESSION["notify"] = "duplicate";
        header("location: ../?users");
        return;
    } else {
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
  //  $name = $_POST["name"];
    $type = $_POST["type"];
    $category = $_POST["category"];

    $sql = "UPDATE `cottage/hall` SET `team`='$team',  `type`='$type', `category`='$category' WHERE id = '$id'";
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

    // Check if the username or email is taken by another user
    $check_sql = "SELECT * FROM `user` WHERE (`uname` = '$uname' OR `email` = '$email') AND `user_id` != '$id'";
    $check_query = mysqli_query($con, $check_sql);

    if (mysqli_num_rows($check_query) > 0) {
        // Username or email already exists for another user
        $_SESSION["notify"] = "duplicate";
        header("location: ../?users");
        return;
    }

    // Update the user information, including the address
    $hashed_pass = password_hash($pass, PASSWORD_BCRYPT); // Use hashed password
    $sql = "UPDATE `user` SET 
            `fname`='$fname', 
            `lname`='$lname', 
            `uname`='$uname', 
            `pass`='$hashed_pass', 
            `user_type_id`='$utype', 
            `address`='$address' 
            WHERE `user_id` = '$id'";

    $query = mysqli_query($con, $sql);

    if ($query) {
        $_SESSION["notify"] = "success";
        header("location: ../?users");
    } else {
        $_SESSION["notify"] = "failed";
        header("location: ../?users");
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



      // Insert Operation for PUMPBOATS
if (isset($_POST["btn-pumpboat-add"])) {
    $license_no = htmlspecialchars($_POST["license_no"], ENT_QUOTES, 'UTF-8');
    $pumpboat_no = htmlspecialchars($_POST["pumpboat_no"], ENT_QUOTES, 'UTF-8');
    $type = htmlspecialchars($_POST["type"], ENT_QUOTES, 'UTF-8');
    $team = htmlspecialchars($_POST["team"], ENT_QUOTES, 'UTF-8');

    // Check for duplicate license_no or pumpboat_no within the same team
    $check_sql = "SELECT * FROM `pumpboats` WHERE (`license_no` = '$license_no' OR `pumpboat_no` = '$pumpboat_no') AND `team` = '$team'";
    $check_query = mysqli_query($con, $check_sql);

    if (mysqli_num_rows($check_query) > 0) {
        // Duplicate entry found
        $_SESSION["notify"] = "duplicate-add";
        header("location: ../?manage_pumpboats");
        return;
    }

    // Insert into the pumpboats table
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
        
       // Update Operation for PUMPBOATS
if (isset($_POST["btn-pumpboat-edit"])) {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $license_no = htmlspecialchars($_POST["license_no"], ENT_QUOTES, 'UTF-8');
    $pumpboat_no = htmlspecialchars($_POST["pumpboat_no"], ENT_QUOTES, 'UTF-8');
    $type = htmlspecialchars($_POST["type"], ENT_QUOTES, 'UTF-8');
    $team = htmlspecialchars($_POST["team"], ENT_QUOTES, 'UTF-8');

    // Check for duplicate license_no or pumpboat_no in other records
    $check_sql = "SELECT * FROM `pumpboats` WHERE (`license_no` = '$license_no' OR `pumpboat_no` = '$pumpboat_no') AND `id` != '$id'";
    $check_query = mysqli_query($con, $check_sql);

    if (mysqli_num_rows($check_query) > 0) {
        // Duplicate entry found
        $_SESSION["notify"] = "duplicate-edit";
        header("location: ../?manage_pumpboats");
        return;
    }

    // Update the pumpboat information
    $sql = "UPDATE `pumpboats` SET 
            `license_no`='$license_no', 
            `pumpboat_no`='$pumpboat_no', 
            `type`='$type', 
            `team`='$team' 
            WHERE `id` = '$id'";
    $query = mysqli_query($con, $sql);

    if ($query) {
        $_SESSION["notify"] = "success-edit";
        header("location: ../?manage_pumpboats");
    } else {
        $_SESSION["notify"] = "failed-edit";
        header("location: ../?manage_pumpboats");
    }
}

        


     // Insert Operation - CATCH BY TEAM
if (isset($_POST["btn-catch-add"])) {
    $team = $_POST["team"];
    $catch_items = $_POST["catch_item"];
    $catch_amounts = $_POST["catch_amount"];
    $catch_kilos = $_POST["catch_kilo"];
    $catch_date = $_POST["catch_date"];

    // Track added record IDs for printing
    $added_ids = [];

    // Prepare the SQL statements for both catch_records and catch_records_sell
    $stmt_catch_records = $con->prepare("INSERT INTO `catch_records`(`team`, `catch_item`, `catch_amount`, `catch_kilo`, `catch_date`) VALUES (?, ?, ?, ?, ?)");
    $stmt_catch_records_sell = $con->prepare("INSERT INTO `catch_records_sell`(`team`, `catch_item`, `catch_amount`, `catch_kilo`, `catch_date`) VALUES (?, ?, ?, ?, ?)");

    if ($stmt_catch_records === false || $stmt_catch_records_sell === false) {
        $_SESSION["notify"] = "failed-add";
        header("location: ../?manage_catch_by_team");
        exit();
    }

    foreach ($catch_items as $index => $catch_item) {
        $catch_amount = $catch_amounts[$index];
        $catch_kilo = $catch_kilos[$index];

        // Bind parameters for catch_records
        $stmt_catch_records->bind_param("ssdds", $team, $catch_item, $catch_amount, $catch_kilo, $catch_date);
        
        // Bind parameters for catch_records_sell
        $stmt_catch_records_sell->bind_param("ssdds", $team, $catch_item, $catch_amount, $catch_kilo, $catch_date);

        // Execute the statements for both tables
        if ($stmt_catch_records->execute() && $stmt_catch_records_sell->execute()) {
            $added_ids[] = $stmt_catch_records->insert_id; // Store the ID of the newly inserted record from catch_records
        } else {
            $_SESSION["notify"] = "failed-add";
            header("location: ../?manage_catch_by_team");
            exit();
        }
    }

    // Close the prepared statements
    $stmt_catch_records->close();
    $stmt_catch_records_sell->close();

    // Set session for print with team information
    $_SESSION["notify"] = "success-add";
    $_SESSION["print_ready_team"] = $team;
    $_SESSION["added_ids"] = $added_ids;

    // Redirect to the print page
    header("location: ../view/print_catch.php");
    exit();
}

// Delete Operation - CATCH BY TEAM
if (isset($_GET["catch-del"])) {
    $id = $_GET["catch-del"];
    
    // Prepare delete statements for both tables
    $stmt_delete_catch_records = $con->prepare("DELETE FROM `catch_records` WHERE id = ?");
    $stmt_delete_catch_records_sell = $con->prepare("DELETE FROM `catch_records_sell` WHERE id = ?");
    
    if ($stmt_delete_catch_records && $stmt_delete_catch_records_sell) {
        // Bind parameter
        $stmt_delete_catch_records->bind_param("i", $id);
        $stmt_delete_catch_records_sell->bind_param("i", $id);
        
        // Execute both delete statements
        if ($stmt_delete_catch_records->execute() && $stmt_delete_catch_records_sell->execute()) {
            $_SESSION["notify"] = "success-delete";
            header("location: ../?manage_catch_by_team");
            exit();
        } else {
            $_SESSION["notify"] = "failed-delete";
            header("location: ../?manage_catch_by_team");
            exit();
        }

        // Close the delete statements
        $stmt_delete_catch_records->close();
        $stmt_delete_catch_records_sell->close();
    } else {
        $_SESSION["notify"] = "failed-delete";
        header("location: ../?manage_catch_by_team");
        exit();
    }
}
// /Delete Operation CATCH BY TEAM


// Insert Operation SELL PRODUCT
if (isset($_POST["btn-sell-product"])) {
    $catch_id = $_POST["catch_id"];
    $quantity_sold = $_POST["quantity_sold"];
    $sale_amount = $_POST["sale_amount"];
    $sale_date = $_POST["sale_date"];
    $buyer_name = $_POST["buyer_name"];

    $sale_id = add_sale($catch_id, $quantity_sold, $sale_amount, $sale_date, $buyer_name);

    if ($sale_id) {
        $_SESSION["notify"] = "success-sale";
        header("location: ../?manage_sell_product");
        exit();
    } else {
        $_SESSION["notify"] = "failed-sale";
        header("location: ../?manage_sell_product");
        exit();
    }
}

// Delete Operation SELL PRODUCT
if (isset($_GET["sell-del"])) {
    $id = $_GET["sell-del"];
    $sql = "DELETE FROM `sales_records` WHERE id = '$id'";
    $query = mysqli_query($con);

    if ($query) {
        $_SESSION["notify"] = "success-delete";
        header("location: ../?manage_sell_product");
        exit();
    } else {
        $_SESSION["notify"] = "failed-delete";
        header("location: ../?manage_sell_product");
        exit();
    }
}
// /Insert Operation SELL PRODUCT