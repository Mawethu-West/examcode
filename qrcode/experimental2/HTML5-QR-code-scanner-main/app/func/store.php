<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once 'database_config.php'; // Include database connection details

// Validate input and sanitize the QR code value
$data = json_decode(file_get_contents('php://input'), true); // Assume JSON input
$qrcodeValue = filter_var($data['qrcode_values'], FILTER_SANITIZE_STRING);

if (empty($qrcodeValue)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing QR code value']);
    exit;
}

try {
    // Connect to the database
   // $conn = new PDO("mysql:host=localhost,dbname=participant_qrcodes", "root", "");   
   // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $hostdb = "localhost";  // MySQl host
$userdb = "root";  // MySQL username
$passdb = "";  // MySQL password
$namedb = "participant_qrcodes";  // MySQL database name

// Establish a connection to the database
$conn = new mysqli($hostdb, $userdb, $passdb, $namedb);

/* Render an error message, to avoid abrupt failure, if the database connection parameters are incorrect */
if ($conn->connect_error) {
	exit("There was an error with your connection: ".$conn->connect_error);
}

    // Check if code already exists and calculate time difference (if applicable)
  $stmt = $conn->prepare("SELECT last_scan_time FROM participant_qrcodes WHERE `qrcode_value` = ?");
$stmt->bind_param("s", $qrcodeValue);
$stmt->execute();
$result = $stmt->get_result(); // Get mysqli_result object
$existingRow = $result->fetch_assoc(); // Fetch as associative array

    $currentTime = time();
    $timeDifference = 0;
    if ($existingRow) {
        $lastScanTime = strtotime($existingRow['last_scan_time']);
        $timeDifference = $currentTime - $lastScanTime;
    }

    // Implement rate limiting using your desired threshold and logic
    $thresholdMinutes = 180; // Example threshold, adjust as needed
    if ($timeDifference < $thresholdMinutes * 30) {
        http_response_code(429);
        echo json_encode(['status' => 'error', 'message' => 'Scan limit exceeded. Please wait ' . ($thresholdMinutes - floor($timeDifference / 60)) . ' minutes and try again.']);
        exit;
    }

    // Update or insert data depending on existence
    if ($existingRow) {
        $stmt = $conn->prepare("UPDATE participant_qrcodes SET usage_count = usage_count + 1, last_scan_time = :currentTime WHERE qrcode_value = :qrcode_value");
        $stmt->bindParam(':currentTime', $currentTime);
        $stmt->bindParam(':qrcode_value', $qrcodeValue);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO participant_qrcodes (qrcode_value, usage_count, last_scan_time) VALUES (:qrcode_value, 1, :currentTime)");
        $stmt->bindParam(':qrcode_value', $qrcodeValue);
        $stmt->bindParam(':currentTime', $currentTime);
        $stmt->execute();
    }

    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'QR code scanned successfully!']);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}

$conn = null; // Close connection
