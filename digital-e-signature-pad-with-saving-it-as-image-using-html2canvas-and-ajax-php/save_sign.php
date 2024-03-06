<?php 
	//$result = array();
	//$imagedata = base64_decode($_POST['img_data']);
	//$filename = md5(date("dmYhisA"));
	//Location to where you want to created sign image
	//$file_name = './doc_signs/'.$filename.'.png';
	//file_put_contents($file_name,$imagedata);
	//$result['status'] = 1;
	//$result['file_name'] = $file_name;
	//echo json_encode($result);
?>
<?php
// Database connection details (replace with your credentials)
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'qrcode';

// Connect to the MySQL database
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

// Retrieve image data and QR code value from POST request
$imagedata = base64_decode($_POST['img_data']);
$qrcodeValue = $_POST['qrcodeValue'] ; // Handle potential absence

// Get current date
$currentDate = date('Y-m-d');

// Prepare the SQL statement with parameter binding
$stmt = $conn->prepare("
    UPDATE exam_log 
    SET signature = ?, time_out = NOW() 
    WHERE student_id = ? AND DATE(time_in) = ?;
");
$stmt->bind_param("sss", $imagedata, $qrcodeValue, $currentDate);

// Execute the statement and handle results
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        $result['status'] = 1;
        $result['message'] = 'Signature updated successfully!';
    } else {
        $result['status'] = 0;
        $result['message'] = 'No record found for the provided QR code.';
    }
} else {
    $result['status'] = 0;
    $result['message'] = 'Error saving signature: ' . $conn->error;
}
// Close the statement and connection
$stmt->close();
$conn->close();

// Encode and output the response
echo json_encode($result);
?>
