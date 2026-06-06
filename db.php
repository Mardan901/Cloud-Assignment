<?php
$host = "bwim1tulidk8xdcvwgwi-mysql.services.clever-cloud.com"; 
$user = "uljgwdxtxae61kuv";
$dbname = "bwim1tulidk8xdcvwgwi";

$pass = "0TAUku0kWyilR8hrl5R8"; 

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
