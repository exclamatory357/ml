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
    $days = $response_data->days; // Correct assignment
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Add your custom styles here */
    </style>
</head>
<body>
<section class="container-fluid">
    <h1>Weather Forecast for <?php echo htmlspecialchars($resolvedAddress); ?></h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Max Temp</th>
                <th>Min Temp</th>
                <th>Precip</th>
                <th>Wspd</th>
                <th>Wgust</th>
                <th>Cloud cover</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($days as $day) { ?>
            <tr>
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

    <h4>API request</h4>
    <p><?php echo htmlspecialchars($api_url); ?></p>

    <div class="dashboard-row">
        <!-- Add your other dashboard boxes here -->
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                            tooltipFormat: 'MMM d, yyyy',
                            displayFormats: {
                                day: 'MMM d'
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
