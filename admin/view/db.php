<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$host = "127.0.0.1";
$username = "u510162695_resevation";
$password = "1Resevation";
$db = "u510162695_resevation";
$port = 3306;

$con = mysqli_connect($host, $username, $password, $db, $port);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

//echo "Connected successfully";

?>
