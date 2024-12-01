<?php
// Function to log out user from all devices
function invalidate_all_sessions($trans_no, $con) {
    $sql = "UPDATE reservation SET adult = 0 WHERE trans_no = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $trans_no);
    $stmt->execute();
}
?>
