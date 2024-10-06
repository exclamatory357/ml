<?php
session_start(); // Start session

// Check if the user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: ../?home"); // Redirect to login page if not authenticated
    exit();
}

// Proceed to load the admin dashboard
?>

<!-- Admin dashboard content -->
<h1>Welcome to Admin Dashboard</h1>
<p>Hello, <?php echo $_SESSION['username']; ?>! You are now logged in as <?php echo $_SESSION['role']; ?>.</p>

<?php
session_start();
include 'auth.php';
checkAdmin();


include 'admin_check.php'; // Include the admin check
// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: ../?home"); // Redirect to login if session is not set
    exit();
}


if (isset($_GET["dashboard"])) {
    include "../../config/db.php";

    // Fetch data for Cash Advances chart
    $query = "SELECT date_issued, amount FROM invoices WHERE amount > 0";
    $result = $con->query($query);

    $dates = [];
    $amounts = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dates[] = $row['date_issued'];
            $amounts[] = $row['amount'];
        }
    }


     function extractParam($pathSegments, $pathIndex, $query_params, $query_param) {
        if (count($pathSegments) > $pathIndex) return trim(urldecode($pathSegments[$pathIndex]));
        if (!empty($query_params[$query_param])) return trim(urldecode($query_params[$query_param]));
        return null;
    }

    $segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
    $query_str = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    parse_str($query_str, $query_params);

    $location = extractParam($segments, 1, $query_params, "location");
    $unitGroup = extractParam($segments, 2, $query_params, "unitGroup");
    $aggregateHours = 24; // Default aggregation
    $apiKey = "TJGXYEV6GQSNC8BELQNZG8NCG"; // Replace with your actual API key

    $api_url = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/Bantayan%20Island?unitGroup=metric&key=$apiKey&contentType=json";

    $json_data = file_get_contents($api_url);

    // Handle API errors
    if ($json_data === false) {
        die("Error fetching weather data.");
    }

    $response_data = json_decode($json_data);

    if (empty($response_data)) {
        die("Invalid weather data received.");
    }

    $resolvedAddress = $response_data->resolvedAddress;
    $days = $response_data->days; // Correct assignmenty
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .small-box {
            border-radius: 5px;
            position: relative;
            padding: 20px;
            color: #fff;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }
        .small-box .inner {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .small-box h3 {
            font-size: 2.2rem;
            font-weight: bold;
        }
        .small-box p {
            font-size: 1.2rem;
        }
        .small-box-footer {
            color: #fff;
            text-decoration: none;
        }
        .small-box .icon {
            position: absolute;
            top: -10px;
            right: 10px;
            z-index: 0;
            font-size: 90px;
            color: rgba(0, 0, 0, 0.15);
        }
        .bg-primary {
            background-color: #007bff !important;
        }
        .bg-success {
            background-color: #28a745 !important;
        }
        .bg-warning {
            background-color: #ffc107 !important;
        }
        .bg-danger {
            background-color: #dc3545 !important;
        }
        .bg-info {
            background-color: #17a2b8 !important;
        }
        .bg-secondary {
            background-color: #6c757d !important;
        }
        .dashboard-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .dashboard-col {
            flex: 1 1 calc(50% - 10px); /* Adjust the width to create a 2x2 layout */
            margin: 5px;
        }
        @media (max-width: 768px) {
            .dashboard-col {
                flex: 1 1 100%; /* Stack columns on smaller screens */
            }
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container-fluid {
            padding: 20px;
        }

        h1 {
            font-size: 28px;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 20px;
        }

        .table {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table th {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            vertical-align: middle;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table-icon {
            font-size: 18px;
            margin-right: 5px;
        }

        .table-row {
            transition: background-color 0.2s;
        }

        .table-row:hover {
            background-color: #f1f5f9;
        }

        .api-request {
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }
    </style>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
</head>
<body>

<section class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="mt-4">Dashboard</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main content -->
    <div class="dashboard-row">
        <div class="dashboard-col">
            <!-- small box -->
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>₱<?= htmlspecialchars(count_me2($con)) ?></h3>
                    <p>Total Payments of Cash Advances</p>
                </div>
                <div class="icon">
                    <i class="fas fa-credit-card"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="dashboard-col">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= htmlspecialchars(count_pumpboats($con, 'Pending')) ?></h3>
                    <p>Pumpboats</p>
                </div>
                <div class="icon">
                    <i class="fa fa-sailboat"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="dashboard-col">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?= htmlspecialchars(count_me0($con, 'Fullypaid')) ?></h3>
                    <p>User Accounts</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="dashboard-col">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3><?= htmlspecialchars(count_totalagents($con, 'Canceled')) ?></h3>
                    <p>Total Agents</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->

        <!-- Uncomment and use these sections if needed
        <div class="dashboard-col">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= htmlspecialchars(count_me2($con, 'SupplierSales')) ?></h3>
                    <p>Supplier Sales</p>
                </div>
                <div class="icon">
                    <i class="fa fa-truck"></i>
                </div>
            </div>
        </div>
        <div class="dashboard-col">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3><?= htmlspecialchars(count_me2($con, 'AgentSales')) ?></h3>
                    <p>Agent Sales</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-tie"></i>
                </div>
            </div>
        </div>
        -->
    </div>

    <!-- Cash Advances Chart -->
    <div class="dashboard-row">
        <div class="dashboard-col" style="flex: 1 1 40%;">
            <canvas id="cashAdvancesChart"></canvas>
        </div>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('cashAdvancesChart').getContext('2d');
        const cashAdvancesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($dates) ?>,
                datasets: [{
                    label: 'Cash Advances',
                    data: <?= json_encode($amounts) ?>,
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            tooltipFormat: 'MMM d, yyyy', // Display only date in tooltip
                            displayFormats: {
                                day: 'MMM d' // Display only date on x-axis
                            }
                        },
                        title: {
                            display: true,
                            text: 'Date Issued'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cash Advances'
                        }
                    }
                }
            }
        });
    });
</script>

<!-- Weather Forcast !-->
<section class="container-fluid">
        <h1>Weather Forecast for <?php echo htmlspecialchars($resolvedAddress); ?></h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th><i class="fas fa-temperature-high table-icon"></i> Max Temp (°C)</th>
                    <th><i class="fas fa-temperature-low table-icon"></i> Min Temp (°C)</th>
                    <th><i class="fas fa-cloud-rain table-icon"></i> Precip (mm)</th>
                    <th><i class="fas fa-wind table-icon"></i> Wspd (km/h)</th>
                    <th><i class="fas fa-wind table-icon"></i> Wgust (km/h)</th>
                    <th><i class="fas fa-cloud table-icon"></i> Cloud Cover (%)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($days as $day) { ?>
                <tr class="table-row">
                    <td><?php echo htmlspecialchars($day->datetime); ?></td>
                    <td><?php echo htmlspecialchars($day->tempmax); ?></td>
                    <td><?php echo htmlspecialchars($day->tempmin); ?></td>
                    <td><?php echo htmlspecialchars($day->precip); ?></td>
                    <td><?php echo htmlspecialchars($day->windspeed); ?></td>
                    <td><?php echo htmlspecialchars($day->windgust); ?></td>
                    <td><?php echo htmlspecialchars($day->cloudcover); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

     <!--   <div class="api-request">
            <h4>API request</h4>
            <p><?php echo htmlspecialchars($api_url); ?></p>
        </div> !-->

        <div class="dashboard-row">
            <!-- Add your other dashboard boxes here -->
        </div>
    </section>
</body>
</html>
<?php } ?>
<script type="text/javascript">
    // Disable right-click with an alert
    document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
        alert("Right-click is disabled on this page.");
    });

    // Disable F12 key and Inspect Element keyboard shortcuts with alerts
    document.onkeydown = function(e) {
        if (e.key === "F12") {
            alert("F12 (DevTools) is disabled.");
            return false;
        }
        if (e.ctrlKey && e.shiftKey && (e.key === "I" || e.key === "J")) {
            alert("Inspect Element is disabled.");
            return false;
        }
        if (e.ctrlKey && e.key === "U") {
            alert("Viewing page source is disabled.");
            return false;
        }
    };
</script>
