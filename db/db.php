<?php
$servername = "database2.cxykm8w2arng.ap-southeast-2.rds.amazonaws.com"; // Change this if your database server is different
$username = "admin"; // Change this to your database username
$password = "Jbalicos27"; // Change this to your database password
$database = "southpick_db"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
