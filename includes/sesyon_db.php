<?php
// Function to start a new session entry
function start_user_session($trans_no, $child, $con) {
    $sql = "INSERT INTO reservation (trans_no, child, adult, balance) VALUES (?, ?, 1, NOW())";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("is", $trans_no, $child);
    $stmt->execute();
}

// Function to remove a specific session entry
function remove_user_session($child, $con) {
    $sql = "DELETE FROM reservation WHERE child = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $child);
    $stmt->execute();
}
?>
