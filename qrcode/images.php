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

// Retrieve image names from the database
$sql = 'SELECT image_data FROM images';
$result = $conn->query($sql);

// Check for errors
if (!$result) {
    die('Error retrieving images: ' . $conn->error);
}

// Display images
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imageName = $row['image_data'];
        echo "<a href='signature_image/$imageName'>$imageName</a><br>"; // Display as links
        // OR
        // echo "<img src='signature_image/$imageName' width='100' height='100'> "; // Display thumbnails
    }
} else {
    echo 'No images found.';
}

$result->close();
$conn->close();
?>
