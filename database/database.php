<?php 

$hostname = "localhost";
$DBUser = "root";
$DBPassword = "";
$DBName = "techunt";

$connection = mysqli_connect($hostname, $DBUser, $DBPassword, $DBName);

if (!$connection) {
    die("Couldn't Connect to the Database");
}

?>