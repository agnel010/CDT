<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    include 'db_connect.php';

    if ($conn->connect_error) {
        throw new Exception('Database connection failed: ' . $conn->connect_error);
    }

    // ✅ Set time zone for PHP
    date_default_timezone_set('Asia/Kolkata');

    // ✅ Set time zone for MySQL session
    $conn->query("SET time_zone = '+05:30'");

    if (!isset($_SESSION['user_id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Please log in to update countdown status'
        ]);
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $countdown_id = (int) ($_POST['countdown_id'] ?? 0);
    $status = trim($_POST['status'] ?? '');

    if ($countdown_id <= 0 || !in_array($status, ['active', 'paused', 'completed'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid countdown ID or status'
        ]);
        exit();
    }

    // ✅ Modify the SQL query based on the status
    if ($status === 'paused') {
        // Update `remaining_time` based on correct IST time
        $sql = "UPDATE countdowns 
                SET remaining_time = TIMESTAMPDIFF(SECOND, NOW(), end_time), status = 'paused' 
                WHERE id = ? AND user_id = ?";
    } elseif ($status === 'completed') {
        // Ensure remaining_time is set to 0 when completed
        $sql = "UPDATE countdowns 
                SET remaining_time = 0, status = 'completed' 
                WHERE id = ? AND user_id = ?";
    } else {
        $sql = "UPDATE countdowns SET status = ? WHERE id = ? AND user_id = ?";
    }

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }

    if ($status === 'paused' || $status === 'completed') {
        $stmt->bind_param("ii", $countdown_id, $user_id);
    } else {
        $stmt->bind_param("sii", $status, $countdown_id, $user_id);
    }

    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Status updated successfully',
        'status' => $status
    ]);

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile()
    ]);
    exit();
}
?>
