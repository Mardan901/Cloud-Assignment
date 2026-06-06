<?php
$servername = "localhost";
$username = "root";   
$password = "";       
$dbname = "steel_db"; 

// Create the connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection works
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>