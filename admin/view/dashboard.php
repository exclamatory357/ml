<?php
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

    //helper method to retrieve data from the URL path or query string
	function extractParam($pathSegments, $pathIndex, $query_params, $query_param) {
        if (count($pathSegments)>$pathIndex) return trim(urldecode($pathSegments[$pathIndex]));
        if ($query_params[$query_param]!=null) return trim(urldecode($query_params[$query_param]));
        return null;
     }
 
     $segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
     $query_str = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
     parse_str($query_str, $query_params);
     //the location for the weather data (an address or partial address)
     $location=extractParam($segments,1, $query_params, "location");
 
     // the unit group - us, metric or uk
     $unitGroup=extractParam($segments,2, $query_params, "unitGroup");
 
     //we want weather data to aggregated to daily details.
     $aggregateHours=24;
     //your API key
     $apiKey="1PYNQ6AWUDJE9AFERDCHJHSXK";
?>
<!DOCTYPE html>
<html lang="en">
<head>

<!-- Weather Forecast request construction -->
<?php	
		$api_url="https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/Bantayan%20Island?unitGroup=metric&key=TJGXYEV6GQSNC8BELQNZG8NCG&contentType=json";

		$json_data = file_get_contents($api_url);

		$response_data = json_decode($json_data);

		$resolvedAddress=$response_data->resolvedAddress;
		$days=$locationInstance->days;
	?>
	<!-- Create the HTML for the weather forecast data -->
	<h1>Weather Forecast for <?php echo $resolvedAddress; ?></h1>
	<table>
		<tr><th>Date</th><th>Max Temp</th><th>Min Temp</th><th>Precip</th><th>Wspd</th><th>Wgust</th><th>Cloud cover</th></tr>
		<?php
		foreach ($day as $days) {
		?>
		<tr>
			 <td><?php echo $day->datetime; ?></td>
			 <td><?php echo $day->tempmax; ?></td>
			 <td><?php echo $day->tempmin; ?></td>
			 <td><?php echo $day->precip; ?></td>
			 <td><?php echo $day->windspeed; ?></td>
			 <td><?php echo $day->windgust; ?></td>
			 <td><?php echo $day->cloudcover; ?></td>
		</tr>
		<?php } ?>
	</table>

	<h4>API request</h4>
	<p>
		<?php echo $api_url; ?>
	</p>
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

</body>
</html>
<?php } ?>
