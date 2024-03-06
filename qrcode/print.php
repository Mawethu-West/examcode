<?php 
// Connect to the database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'qrcode';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

$sql = "SELECT image_data FROM images WHERE id = ?"; // Replace 'id' with your selection criteria
$stmt = $conn->prepare($sql);
$imageid = 27;
$stmt->bind_param('i', $imageid); // Replace with the specific image ID for printing
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$dataURI = $row['image_data'];

$stmt->close(); // Close prepared statement
$conn->close(); // Close database connection


$parts = explode(';', $dataURI);
$mimeType = explode(':', $parts[0])[1];
$base64Data = explode(',', $parts[1])[1];

$imageData = base64_decode($base64Data);


header("Content-Type: $mimeType");
header('Content-Disposition: inline; filename="' . uniqid() . '.' . explode('/', $mimeType)[1] . '"'); // Set filename and disposition
echo $imageData;

?>
