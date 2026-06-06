<?php
// 1. Initialize a secure SQL connection object
$conn = mysqli_init();

if (!$conn) {
    die("mysqli_init failed");
}

$host = 'steel-db-steel-db.g.aivencloud.com'; 
$user = 'avnadmin';
$pass = 'AVNS_FuuyThp7HaLjxiETeCv';
$port = 18828;

// Force connection to the default cloud workspace
$connect_db = 'defaultdb'; 

// Force PHP to use the secure SSL handshake required by Aiven
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

// 2. Establish the base handshake using 'defaultdb'
if (!mysqli_real_connect($conn, $host, $user, $pass, $connect_db, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Connection failed: " . mysqli_connect_error());
}

// 3. Now that we are inside, safely switch over to your uploaded database layout
if (!mysqli_select_db($conn, 'a264133_b7d5eblm')) {
    die("Database selection failed: " . mysqli_error($conn));
}
?>
