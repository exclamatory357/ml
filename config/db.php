<?php

$host = "sql109.infinityfree.com";
$username = "if0_36823419";
$password = "nexus3572";
$db = "if0_36823419_resevation";

$con = mysqli_connect($host, $username, $password, $db);

if ($con) {
    echo "Connected successfully";
} else {
    echo "Connection failed: " . mysqli_connect_error();
}

?>
