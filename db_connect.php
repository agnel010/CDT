<?php
$servername = "localhost"; 
$username = "root"; 
$password = "root"; 
$database = "CountDownTimer"; 
$port = 3307; // Port should be an integer, not a string

// Create connection with correct parameter order
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set PHP and MySQL to use Indian Standard Time (IST)
date_default_timezone_set('Asia/Kolkata'); 
$conn->query("SET time_zone = '+05:30'");

// Debug: Check MySQL's current time
$result = $conn->query("SELECT NOW()");
$row = $result->fetch_assoc();
error_log("MySQL Time: " . $row['NOW()']); // Logs the current MySQL time

?>
