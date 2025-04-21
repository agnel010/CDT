<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "CountDownTimer";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    $error = "Connection failed: " . $conn->connect_error;
    $countdowns = [];
    $user_id = null;
} else {
    $countdowns = [];
    $error = null;
    $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

    if ($user_id) {
        $sql = "SELECT 
                    countdown_name,
                    CONCAT(
                        LPAD(hours, 2, '0'), ':',
                        LPAD(minutes, 2, '0'), ':',
                        LPAD(seconds, 2, '0')
                    ) AS duration,
                    created_at,
                    end_time,
                    status,
                    remaining_time
                FROM countdowns 
                WHERE user_id = $user_id
                ORDER BY created_at DESC";

        $result = $conn->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $countdowns[] = $row;
            }
        } else {
            $error = "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>