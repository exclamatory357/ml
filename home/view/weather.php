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
    $api_url = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/$location?unitGroup=$unitGroup&key=$apiKey&contentType=json";

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
                        <th><i class="fas fa-sun table-icon"></i> UV Index</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($days as $day) { ?>
                    <tr>
                        <td data-label="Date"><?php echo htmlspecialchars($day->datetime); ?></td>
                        <td data-label="Max Temp"><?php echo htmlspecialchars($day->tempmax); ?> (°C)</td>
                        <td data-label="Min Temp"><?php echo htmlspecialchars($day->tempmin); ?> (°C)</td>
                        <td data-label="Precipitation"><?php echo htmlspecialchars($day->precip); ?> (mm)</td>
                        <td data-label="Wind Speed"><?php echo htmlspecialchars($day->windspeed); ?> (km/h)</td>
                        <td data-label="Wind Gust"><?php echo htmlspecialchars($day->windgust); ?> (km/h)</td>
                        <td data-label="Cloud Cover"><?php echo htmlspecialchars($day->cloudcover); ?> (%)</td>
                        <td data-label="UV Index"><?php echo htmlspecialchars($day->uvindex); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Styles -->
<style>
    h1 {
        text-align: center;
        margin-bottom: 40px;
        font-weight: 300;
        color: #333;
    }

    .weather-table {
        width: 100%;
        border-collapse: collapse;
        animation: fadeIn 1s ease-out;
    }

    .weather-table thead {
        background-color: #4a90e2;
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
        color: #4a90e2;
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

<!-- JavaScript -->
<script>
// You can include more JavaScript here for interactions or animations
</script>

<?php
} else {
    echo " ";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
</body>
</html>
