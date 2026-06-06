<?php
$host = 'bwim1tulidk8xdcvwgwi-mysql.services.clever-cloud.com'; 
$user = 'uljgwdxtxae61kuv';
$dbname = 'bwim1tulidk8xdcvwgwi';

// Click the little orange padlock icon next to Password on your screen to copy your password!
$pass = 'IkBlDd8CQ0QTawnrS3Hs'; 

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
