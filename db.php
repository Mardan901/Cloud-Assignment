<?php
// Initialize a secure SQL connection object
$conn = mysqli_init();

if (!$conn) {
    die("mysqli_init failed");
}

$host = 'steel-db-steel-db.g.aivencloud.com'; 
$user = 'avnadmin';
$pass = 'AVNS_FuuyThp7HaLjxiETeCv';
$dbname = 'defaultdb';
$port = 18828;


mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

// Connect using the configured parameters
if (!mysqli_real_connect($conn, $host, $user, $pass, $dbname, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
