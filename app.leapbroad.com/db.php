<?php
$servername = "localhost"; // Change if needed
$username = "wiecedun_leapbroad1"; // Your MySQL username
$password = "Zeraora@123#$%"; // Your MySQL password
$dbname = "wiecedun_leapbroad"; // Change this to your database name

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
