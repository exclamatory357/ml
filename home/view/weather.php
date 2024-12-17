<?php
if (isset($_GET["weather"])) {
    // Function to extract parameters from URL segments or query parameters
    function extractParam($pathSegments, $pathIndex, $query_params, $query_param) {
        if (count($pathSegments) > $pathIndex) return trim(urldecode($pathSegments[$pathIndex]));
        if (!empty($query_params[$query_param])) return trim(urldecode($query_params[$query_param]));
        return null;
    }

    // Parse the URL to get segments and query parameters
    $segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
    $query_str = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    parse_str($query_str, $query_params);

    // Extract parameters for location and unit group
    $location = extractParam($segments, 1, $query_params, "location") ?? 'Bantayan Island';
    $unitGroup = extractParam($segments, 2, $query_params, "unitGroup") ?? 'metric';

    // Your API key (replace with your actual API key)
    $apiKey = "TJGXYEV6GQSNC8BELQNZG8NCG"; // Replace with your actual API key

    // Build the API URL
    $api_url = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/Bantayan%20Island?unitGroup=metric&key=$apiKey&contentType=json";

    // Fetch weather data from the API
    $json_data = file_get_contents($api_url);

    // Handle API errors
    if ($json_data === false) {
        die("Error fetching weather data.");
    }

    // Decode the JSON response
    $response_data = json_decode($json_data);

    // Check if the response is valid
    if (empty($response_data)) {
        die("Invalid weather data received.");
    }

    // Extract the resolved address and weather details
    $resolvedAddress = $response_data->resolvedAddress;
    $days = $response_data->days;

    // Prepare data for the chart
    $dates = [];
    $maxTemps = [];
    $minTemps = [];
    $precipitations = [];
    $windSpeeds = [];

    foreach ($days as $day) {
        $dates[] = $day->datetime;
        $maxTemps[] = $day->tempmax;
        $minTemps[] = $day->tempmin;
        $precipitations[] = $day->precip;
        $windSpeeds[] = $day->windspeed;
    }
    ?>

    <!-- Main content -->
    <section class="content">
        <div class="container">
            <h1><i class="fas fa-sun"></i> Weather Forecast for <?php echo htmlspecialchars($resolvedAddress); ?> <i class="fas fa-cloud-sun"></i></h1>

            <!-- Table of weather data -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover weather-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th><i class="fas fa-temperature-high table-icon"></i> Max Temp (°C)</th>
                            <th><i class="fas fa-temperature-low table-icon"></i> Min Temp (°C)</th>
                            <th><i class="fas fa-cloud-rain table-icon"></i> Precipitation (mm)</th>
                            <th><i class="fas fa-wind table-icon"></i> Wind Speed (km/h)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($days as $day) { ?>
                        <tr>
                            <td data-label="Date"><?php echo htmlspecialchars($day->datetime); ?></td>
                            <td data-label="Max Temp"><?php echo htmlspecialchars($day->tempmax); ?>(°C)</td>
                            <td data-label="Min Temp"><?php echo htmlspecialchars($day->tempmin); ?>(°C)</td>
                            <td data-label="Precipitation"><?php echo htmlspecialchars($day->precip); ?>(mm)</td>
                            <td data-label="Wind Speed"><?php echo htmlspecialchars($day->windspeed); ?>(km/h)</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Graphs -->
            <div class="chart-container">
                <canvas id="tempChart"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="precipChart"></canvas>
            </div>
        </div>
    </section>

    <!-- Styles -->
    <style>
        .content {
            margin-top: 30px;
            font-family: 'Roboto', sans-serif;
        }
        h1 {
            text-align: center;
            margin-bottom: 40px;
            font-weight: 300;
            color: #333;
        }
        .weather-table {
            width: 100%;
            border-collapse: collapse;
        }
        .weather-table thead {
            background-color: rgb(235, 8, 0);
            color: #fff;
        }
        .weather-table th, .weather-table td {
            padding: 15px;
            text-align: center;
            vertical-align: middle;
            border-bottom: 1px solid #ddd;
        }
        .weather-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .weather-table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .table-icon {
            margin-right: 5px;
            color: rgb(15, 115, 228);
        }
        .chart-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto 50px;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .weather-table thead {
                display: none;
            }
            .weather-table, .weather-table tbody, .weather-table tr, .weather-table td {
                display: block;
                width: 100%;
            }
            .weather-table tr {
                margin-bottom: 15px;
            }
            .weather-table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }
            .weather-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: calc(50% - 30px);
                padding-right: 10px;
                text-align: left;
                font-weight: bold;
            }
        }
    </style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.10/css/weather-icons.min.css" rel="stylesheet">
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data for the charts
        var dates = <?php echo json_encode($dates); ?>;
        var maxTemps = <?php echo json_encode($maxTemps); ?>;
        var minTemps = <?php echo json_encode($minTemps); ?>;
        var precipitations = <?php echo json_encode($precipitations); ?>;
        var windSpeeds = <?php echo json_encode($windSpeeds); ?>;

        // Max and Min Temperature Chart
        var tempCtx = document.getElementById('tempChart').getContext('2d');
        var tempChart = new Chart(tempCtx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Max Temp (°C)',
                    data: maxTemps,
                    borderColor: 'rgb(255, 99, 132)',
                    fill: false,
                    tension: 0.4
                },
                {
                    label: 'Min Temp (°C)',
                    data: minTemps,
                    borderColor: 'rgb(54, 162, 235)',
                    fill: false,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 1000,
                    easing: 'easeOutBounce'
                }
            }
        });

        // Precipitation Chart
        var precipCtx = document.getElementById('precipChart').getContext('2d');
        var precipChart = new Chart(precipCtx, {
            type: 'bar',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Precipitation (mm)',
                    data: precipitations,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuad'
                }
            }
        });
    </script>

<?php
} else {
    echo " ";
}
?>
