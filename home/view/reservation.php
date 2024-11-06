<?php
session_start();
include "../../config/db.php"; // Include the external database connection file

// Check if the user is logged in
if (isset($_SESSION["username"])) {
    $user_id = $_SESSION["user_id"]; // Assuming user_id is stored in session

    // Initialize notifications array
    $notifications = [];
    $team = "No Team Found"; // Default team value
    $full_name = ""; // Default full name value

    // Check if `?request` is in the URL
    if (isset($_GET["request"])) {
        // Fetch notifications for overdue cash advances by 15 days
        $stmt = $con->prepare("SELECT id, amount, date FROM cash_advances WHERE user_id = ? AND amount > 0 AND archived = 0");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $current_date = new DateTime();
        while ($row = $result->fetch_assoc()) {
            $cash_advance_date = new DateTime($row['date']);
            $interval = $cash_advance_date->diff($current_date);

            if ($interval->days >= 15) {
                $notifications[] = "You have a pending balance of ₱" . $row['amount'] . " for cash advance ID " . $row['id'] . ". Please make sure to pay it off.";
            }
        }
        $stmt->close();

        // Fetch user details for modals
        $user_stmt = $con->prepare("SELECT fname, mname, lname FROM user WHERE user_id = ?");
        $user_stmt->bind_param("i", $user_id);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();
        $user_data = $user_result->fetch_assoc();
        $full_name = htmlspecialchars($user_data['fname'] . ' ' . $user_data['mname'] . ' ' . $user_data['lname']);
        $user_stmt->close();

        // Fetch team information based on user details
        $name_to_match = $user_data['fname'] . ' ' . $user_data['mname'] . ' ' . $user_data['lname'];
        $team_stmt = $con->prepare("SELECT team FROM `cottage/hall` WHERE name = ?");
        $team_stmt->bind_param("s", $name_to_match);
        $team_stmt->execute();
        $team_result = $team_stmt->get_result();
        if ($team_result->num_rows > 0) {
            $team_data = $team_result->fetch_assoc();
            $team = htmlspecialchars($team_data['team']); // Set the team value
        }
        $team_stmt->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Requests</title>
    <style>
    /* Global Styling */
    body {
        background-color: #f8f9fa;
        font-family: 'Arial', sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
    }

    /* Header Styling */
    <?php if (isset($_GET["request"])) { ?>
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
   /*     background-color: #b11226;
        color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
    }

    .header h1 {
        margin: 0;
        font-size: 26px;
        letter-spacing: 1px;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .notification-container {
        position: relative;
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    .notification-icon {
        font-size: 24px;
        color: blue;
    }

    .notification-badge {
        position: absolute;
        top: -5px;
        right: -10px;
        background: #e63946;
        color: white;
        border-radius: 50%;
        padding: 3px 6px;
    }
    <?php } ?>

    /* Enhanced Table Styling */
    .container h2 {
        color: #b11226;
        font-weight: bold;
        margin-top: 20px;
        text-align: center;
        font-size: 28px;
    }

    .table {
        width: 100%;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        margin-top: 20px;
    }

    .table th, .table td {
        padding: 15px 20px;
        text-align: center;
        border-bottom: 1px solid #e0e0e0;
    }

    .table th {
        background-color: #b11226;
        color: white;
        font-weight: bold;
        font-size: 16px;
    }

    .table tbody tr:hover {
        background-color: #f8f8f8;
        cursor: pointer;
    }

    .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6;
    }

    /* Responsive Table */
    @media (max-width: 768px) {
        .header {
            flex-direction: column;
            text-align: center;
        }
        .user-info {
            gap: 10px;
            margin-top: 10px;
        }
        .table th, .table td {
            padding: 10px;
        }
    }
    </style>
</head>
<body>
<?php if (isset($_GET["request"])) { ?>
<div class="header">
    <h1>Welcome, <?php echo $full_name; ?></h1>
    <div class="user-info">
        <div class="notification-container" onclick="showNotifications()">
            <i class="glyphicon glyphicon-bell notification-icon"></i>
            <?php if (count($notifications) > 0) { ?>
                <span class="notification-badge"><?php echo count($notifications); ?></span>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>

<div class="container mt-5">
    <?php if (isset($_GET["request"])) { ?>
        <div class="mt-5 d-flex justify-content-center">
            <button type="button" class="btn btn-primary mx-2" data-toggle="modal" data-target="#maintenanceRequestModal">
                Open Maintenance Request Form
            </button>
            <button type="button" class="btn btn-primary mx-2" data-toggle="modal" data-target="#cashAdvanceRequestModal">
                Open Cash Advance Request Form
            </button>
        </div>

        <!-- Maintenance Request Modal -->
        <div class="modal fade" id="maintenanceRequestModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Maintenance Request Form</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="function/function_crud.php" method="post">
                            <div class="mb-3">
                                <label for="item_name">Item Name:</label>
                                <input type="text" id="item_name" name="item_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="team">Team:</label>
                                <input type="text" id="team" name="team" class="form-control" value="<?php echo $team; ?>" readonly>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="maintenance_request" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cash Advance Request Modal -->
        <div class="modal fade" id="cashAdvanceRequestModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cash Advance Request Form</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="function/function_crud.php" method="post">
                            <div class="mb-3">
                                <label for="employee_name">Employee Name:</label>
                                <input type="text" id="employee_name" name="employee_name" class="form-control" value="<?php echo $full_name; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="amount">Amount:</label>
                                <input type="number" id="amount" name="amount" class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="cash_advance" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Grid Views -->
        <div class="mt-5">
            <h2>Maintenance Requests</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item Name</th>
                        <th>Team</th>
                        <th>Request Date</th>
                        <th>Admin Comment</th>
                        <th>Admin Approval</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM maintenance_requests WHERE user_id = $user_id";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["item_name"] . "</td>";
                            echo "<td>" . $row["description"] . "</td>";
                            echo "<td>" . $row["request_date"] . "</td>";
                            echo "<td>" . $row["admin_comment"] . "</td>";
                            echo "<td>" . $row["admin_approval"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            <h2>Cash Advances</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Remaining Amount</th>
                        <th>Original Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM cash_advances WHERE user_id = $user_id";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>₱" . $row["amount"] . "</td>";
                            echo "<td>₱" . $row["original_amount"] . "</td>";
                            echo "<td>" . $row["date"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    function showNotifications() {
        let notifications = <?php echo json_encode($notifications); ?>;
        Swal.fire({
            icon: notifications.length ? 'info' : 'warning',
            title: notifications.length ? 'Notifications' : 'No Notifications',
            html: notifications.length ? notifications.join("<br>") : 'You have no new notifications at this time.',
            width: 600,
        });
    }
</script>
</body>
</html>

<?php
    $con->close();
} else {
    echo " ";
}
