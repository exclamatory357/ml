<?php

include "../../config/db.php";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the catch_date dynamically from the request
if (isset($_GET['catch_date']) && !empty($_GET['catch_date'])) {
    $catch_date = $_GET['catch_date'];

    // Fetch data from catch_records table where catch_date matches
    $sql = "SELECT * FROM catch_records WHERE catch_date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $catch_date); // Bind the dynamic date parameter
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // Return an error message if catch_date is missing
    echo json_encode(["error" => "catch_date parameter is required."]);
}

$conn->close();
?>
