<?php
include "../../config/db.php"; // Database connection

session_start();
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    
    // Fetch user details
    $user_query = "SELECT fname, mname, lname FROM users WHERE id = ?";
    $stmt = $con->prepare($user_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user = $user_result->fetch_assoc();
    
    if ($user) {
        // Construct full name
        $full_name = $user['fname'] . ' ' . $user['mname'] . ' ' . $user['lname'];
        
        // Query the cottage/hall table to get the team name
        $team_query = "SELECT team FROM `cottage/hall` WHERE team = ?";
        $team_stmt = $con->prepare($team_query);
        $team_stmt->bind_param("s", $full_name);
        $team_stmt->execute();
        $team_result = $team_stmt->get_result();
        
        if ($team_result->num_rows > 0) {
            $team = $team_result->fetch_assoc();
            echo json_encode(['team' => $team['team']]);
        } else {
            echo json_encode(['team' => '']);
        }
    }
    $stmt->close();
    $con->close();
}
?>
