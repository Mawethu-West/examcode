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

// Prepare the SQL statement without parameter binding
$stmt = $conn->prepare('SELECT student_id, signature FROM exam_log');

// Execute the statement and handle errors
if ($stmt->execute()) {
  $result = $stmt->get_result();

  while ($row = $result->fetch_assoc()) {
    $imagedata = $row['signature'];
    $id = $row['student_id'];
    echo '<div style="display: flex; align-items: center;">';
    echo "<span>Image ID: $id</span>";
    echo '<img src="data:image/png;base64,' . base64_encode($imagedata) . '" style="margin-left: 10px;"/>';
    echo '</div>';
  }
} else {
  echo 'Error retrieving images: ' . $conn->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>