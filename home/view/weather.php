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
                        <tr>
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
        </div>
    </section>

    <!-- Styles -->
    <style>
    /* Container styling */
    .content {
        margin: 30px auto;
        font-family: 'Roboto', sans-serif;
        max-width: 1200px;
        animation: fadeIn 1s ease-out; /* Fade-in effect on page load */
    }

    h1 {
        text-align: center;
        margin-bottom: 40px;
        font-weight: 500;
        color: #4a90e2;
        font-size: 2rem;
        text-transform: capitalize;
        animation: slideIn 1s ease-out; /* Slide-in effect for header */
    }

    .weather-table {
        width: 100%;
        border-collapse: collapse;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        opacity: 0;
        animation: fadeInTable 1s ease-out forwards; /* Table fade-in effect */
    }

    .weather-table thead {
        background-color: #4a90e2;
        color: #fff;
        animation: fadeInThead 0.8s ease-out; /* Header fade-in */
    }

    .weather-table th,
    .weather-table td {
        padding: 15px;
        text-align: center;
        border: 1px solid #e0e0e0;
        transition: transform 0.3s ease-in-out, background-color 0.3s ease;
    }

    .weather-table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .weather-table tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    .weather-table tbody tr:hover {
        background-color: #dfe9f3;
        transform: scale(1.02); /* Slight scale effect on hover */
        transition: transform 0.2s ease-in-out, background-color 0.2s ease;
    }

    .table-icon {
        margin-right: 8px;
        color: #4a90e2;
    }

    .weather-table td[data-label]:before {
        font-weight: bold;
        font-size: 0.9rem;
        text-transform: uppercase;
        color: #4a90e2;
    }

    /* Conditional formatting for weather data */
    .weather-table td[data-label="Max Temp"] {
        color: #e57373;
    }
    .weather-table td[data-label="Min Temp"] {
        color: #64b5f6;
    }
    .weather-table td[data-label="Precipitation"] {
        color: #81c784;
    }
    .weather-table td[data-label="Wind Speed"],
    .weather-table td[data-label="Wind Gust"] {
        color: #ffb74d;
    }
    .weather-table td[data-label="Cloud Cover"] {
        color: #90a4ae;
    }

    /* Fade-in effect for the table when it's loaded */
    @keyframes fadeInTable {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    /* Slide-in animation for the header */
    @keyframes slideIn {
        0% { transform: translateY(-30px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }

    /* Fade-in effect for the table header */
    @keyframes fadeInThead {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    /* Fade-in effect for content */
    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    /* Responsive styling */
    @media (max-width: 767px) {
        .weather-table thead {
            display: none;
        }
        .weather-table,
        .weather-table tbody,
        .weather-table tr,
        .weather-table td {
            display: block;
            width: 100%;
        }
        .weather-table tr {
            margin-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
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
            font-weight: bold;
        }
    }
</style>


    <!-- JavaScript -->
   

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
    <title>kwe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    
</body>
</html>