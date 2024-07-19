<?php

error_reporting(0);

$host = "sql109.infinityfree.com"; // The hostname from your MySQL details on InfinityFree
$username = "if0_36823419"; // Your MySQL username on InfinityFree
$password = "nexus3572"; // Your MySQL password on InfinityFree
$db = "if0_36823419_resevation"; // The full database name on InfinityFree

$con = mysqli_connect($host, $username, $password, $db);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
?>
