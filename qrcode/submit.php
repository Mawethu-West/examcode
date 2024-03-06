<?php
// Connect to the MySQL database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'qrcode';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

// Get the image data from the POST request
$imageData = $_POST['image'];

// Convert the image data from base64 to binary
$imageData = base64_decode($imageData);

// Generate a unique name for the image
$imageName = uniqid() . '.png';

// Save the image data to a file
file_put_contents('signature_image/' . $imageName, $imageData);

// Insert the image name into the images table
$stmt = $conn->prepare('INSERT INTO images (image_data) VALUES (?)');
$stmt->bind_param('s', $imageName);

if ($stmt->execute()) {
  echo 'Image successfully inserted';
} else {
  echo 'Error submitting image: ' . $conn->error;
}

$stmt->close();
$conn->close();
?>