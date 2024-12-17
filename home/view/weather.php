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
    $current_conditions = $response_data->currentConditions;
?>

<!-- Main content -->
<section class="content">
    <div class="container">
        <!-- Current Weather -->
        <div class="current-weather">
            <h2>Current Weather in <?php echo htmlspecialchars($resolvedAddress); ?></h2>
            <div class="current-info">
                <div class="weather-icon">
                    <!-- Dynamic weather icon for current conditions -->
                    <img src="https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/icons/<?php echo $current_conditions->icon; ?>.png" alt="<?php echo htmlspecialchars($current_conditions->conditions); ?>">
                </div>
                <div class="temp-details">
                    <p class="temp"><?php echo $current_conditions->temp; ?>°C</p>
                    <p class="condition"><?php echo $current_conditions->conditions; ?></p>
                    <p class="wind-speed">Wind: <?php echo $current_conditions->windspeed; ?> km/h</p>
                    <p class="humidity">Humidity: <?php echo $current_conditions->humidity; ?>%</p>
                </div>
            </div>
        </div>

        <!-- 7-Day Forecast -->
        <h3>7-Day Forecast</h3>
        <div class="forecast">
            <?php foreach ($days as $day) { ?>
            <div class="forecast-card">
                <div class="forecast-icon">
                    <!-- Dynamic icon for each day -->
                    <img src="https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/icons/<?php echo $day->icon; ?>.png" alt="<?php echo htmlspecialchars($day->conditions); ?>">
                </div>
                <p class="date"><?php echo htmlspecialchars($day->datetime); ?></p>
                <p class="temp"><?php echo $day->tempmax; ?>°C / <?php echo $day->tempmin; ?>°C</p>
                <p class="precip">Precip: <?php echo $day->precip; ?>mm</p>
                <p class="windspeed">Wind: <?php echo $day->windspeed; ?> km/h</p>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Styles -->
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    h2, h3 {
        text-align: center;
        color: #333;
        font-size: 28px;
    }

    .current-weather {
        display: flex;
        justify-content: center;
        background: #fff;
        padding: 30px;
        margin-bottom: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .current-info {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .weather-icon img {
        width: 100px;
        height: 100px;
    }

    .temp-details {
        margin-left: 20px;
    }

    .temp {
        font-size: 48px;
        color: #4a90e2;
    }

    .condition {
        font-size: 20px;
        color: #555;
    }

    .wind-speed, .humidity {
        font-size: 14px;
        color: #888;
    }

    .forecast {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .forecast-card {
        width: 180px;
        background: #fff;
        padding: 15px;
        margin: 10px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease;
    }

    .forecast-card:hover {
        transform: scale(1.05);
    }

    .forecast-icon img {
        width: 50px;
        height: 50px;
    }

    .date {
        font-weight: bold;
        margin-top: 10px;
    }

    .temp {
        font-size: 16px;
        margin: 5px 0;
    }

    .precip, .windspeed {
        font-size: 12px;
        color: #666;
    }

    @media (max-width: 767px) {
        .forecast {
            flex-direction: column;
        }
    }
</style>

<!-- JavaScript -->
<script>
    // Optionally, add interactivity or animations here
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
