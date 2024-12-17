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
?>

<!-- Main content -->
<section class="content">
    <div class="container">
        <h1>Weather Forecast for <?php echo htmlspecialchars($resolvedAddress); ?></h1>

        <!-- Table with animations and icons -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover weather-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th><i class="fas fa-temperature-high table-icon"></i> Max Temp (°C)</th>
                        <th><i class="fas fa-temperature-low table-icon"></i> Min Temp (°C)</th>
                        <th><i class="fas fa-cloud-rain table-icon"></i> Precipitation (mm)</th>
                        <th><i class="fas fa-wind table-icon"></i> Wind Speed (km/h)</th>
                        <th><i class="fas fa-wind table-icon"></i> Wind Gust (km/h)</th>
                        <th><i class="fas fa-cloud table-icon"></i> Cloud Cover (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($days as $day) { ?>
                    <tr class="table-row">
                        <td data-label="Date"><?php echo htmlspecialchars($day->datetime); ?></td>
                        <td data-label="Max Temp"><?php echo htmlspecialchars($day->tempmax); ?>(°C)</td>
                        <td data-label="Min Temp"><?php echo htmlspecialchars($day->tempmin); ?>(°C)</td>
                        <td data-label="Precipitation"><?php echo htmlspecialchars($day->precip); ?>(mm)</td>
                        <td data-label="Wind Speed"><?php echo htmlspecialchars($day->windspeed); ?>(km/h)</td>
                        <td data-label="Wind Gust"><?php echo htmlspecialchars($day->windgust); ?>(km/h)</td>
                        <td data-label="Cloud Cover"><?php echo htmlspecialchars($day->cloudcover); ?>(%)</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Chart for analytical graphs -->
        <div class="chart-container">
            <canvas id="weatherChart"></canvas>
        </div>
    </div>
</section>

<!-- Styles -->
<style>
    /* Modern and detailed styles for the weather table */
    h1 {
        text-align: center;
        margin-bottom: 40px;
        font-weight: 300;
        color: #333;
    }
    .weather-table {
        width: 100%;
        border-collapse: collapse;
        animation: fadeIn 1s ease-in-out;
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
        cursor: pointer;
        transform: scale(1.05);
        transition: transform 0.2s ease;
    }
    .table-icon {
        margin-right: 5px;
        color: rgb(15, 115, 228);
    }
    .table-row {
        animation: slideIn 0.5s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes slideIn {
        from { transform: translateX(-100%); }
        to { transform: translateX(0); }
    }

    /* Chart styling */
    .chart-container {
        margin-top: 30px;
        text-align: center;
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

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Prepare data for chart
    const labels = <?php echo json_encode(array_map(function($day) { return $day->datetime; }, $days)); ?>;
    const maxTemps = <?php echo json_encode(array_map(function($day) { return $day->tempmax; }, $days)); ?>;
    const minTemps = <?php echo json_encode(array_map(function($day) { return $day->tempmin; }, $days)); ?>;

    // Weather icons based on conditions
    const weatherIcons = {
        sunny: 'fas fa-sun',
        cloudy: 'fas fa-cloud',
        rainy: 'fas fa-cloud-showers-heavy',
        windy: 'fas fa-wind',
    };

    // Add dynamic icon for the chart
    const ctx = document.getElementById('weatherChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Max Temp (°C)',
                data: maxTemps,
                borderColor: 'rgb(255, 99, 132)',
                fill: false
            }, {
                label: 'Min Temp (°C)',
                data: minTemps,
                borderColor: 'rgb(54, 162, 235)',
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        title: function(tooltipItem) {
                            const maxTemp = tooltipItem[0].raw;
                            if (maxTemp >= 30) {
                                return '☀️ Sunny';
                            } else if (maxTemp >= 20) {
                                return '☁️ Cloudy';
                            } else {
                                return '🌧️ Rainy';
                            }
                        }
                    }
                }
            },
            elements: {
                point: {
                    radius: 0
                }
            }
        }
    });
</script>
<?php
}
?>
