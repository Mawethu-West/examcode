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
    $hostdb = "localhost";  // MySQl host
    $userdb = "root";  // MySQL username
    $passdb = "";  // MySQL password
    $namedb = "qrcode";  // MySQL database name

    // Establish a connection to the database
    $conn = new mysqli($hostdb, $userdb, $passdb, $namedb);

    /* Render an error message, to avoid abrupt failure, if the database connection parameters are incorrect */
    if ($conn->connect_error) {
        exit("There was an error with your connection: ".$conn->connect_error);
    }
    
    // Check for QR code match in participant_qrcodes table
    $stmt = $conn->prepare("SELECT student_id FROM students_details WHERE `student_id` = ?");
    $stmt->bind_param("s", $qrcodeValue);
    $stmt->execute();
    $result = $stmt->get_result();
    $matchingRow = $result->fetch_assoc();
    
    if ($matchingRow) {
        // Check if QR code already exists in entries table
        $stmt = $conn->prepare("SELECT student_id FROM exam_log WHERE `student_id` = ?");
        $stmt->bind_param("s", $qrcodeValue);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingRow = $result->fetch_assoc();
    
        if ($existingRow) {
            // QR code already scanned, display error
            http_response_code(200);
            echo json_encode(['status' => 'error', 'message' => 'QR code already scanned']);
        } else {
            // QR code not scanned before, insert into entries
            $stmt = $conn->prepare("INSERT INTO exam_log (student_id, time_in) VALUES (?, ?)");
            $stmt->bind_param("si", $qrcodeValue, $currentTime);
            $stmt->execute();
    
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'QR code scanned successfully!']);
        }
    } 
    else {
         //QR code not found in participant_qrcodes, display error
        http_response_code(200);
        echo json_encode(['status' => 'error', 'message' => 'QR code not recognized']);
    }
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}

$conn = null; // Close connection
?>
