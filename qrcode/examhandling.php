<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>examhandling</title>
</head>
<body>
  
</body>
</html>
<?php

// Start session (if needed for your application)
session_start();

// Include database connection file (make sure the path is correct)
include("includes/db.php");

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $invigilator = filter_input(INPUT_POST, 'invigilator', FILTER_SANITIZE_STRING);
    $course_code = filter_input(INPUT_POST, 'course_code', FILTER_SANITIZE_STRING);
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
    $session = filter_input(INPUT_POST, 'session', FILTER_SANITIZE_STRING);

    // Validate data (consider implementing additional validation if needed)
    $errors = [];
    if (empty($invigilator)) {
        $errors[] = "Invigilator name is required.";
    }
    if (empty($course_code)) {
        $errors[] = "Course code is required.";
    }
    if (empty($date)) {
        $errors[] = "Date is required.";
    }
    if (empty($session)) {
        $errors[] = "Session (morning/afternoon) is required.";
    }

    // If there are no errors, proceed with data processing and insertion
    if (empty($errors)) {

        try {
            // Connect to the database using PDO
            $conn = new PDO("mysql:host=localhost;dbname=qrcode", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare the SQL statement with placeholders
            $sql = "INSERT INTO exams (invigilator, course_code, date, session)
                   VALUES (:invigilator, :course_code, :date, :session)";
            $stmt = $conn->prepare($sql);

            // Bind parameters to the statement
            $stmt->bindParam(':invigilator', $invigilator, PDO::PARAM_STR);
            $stmt->bindParam(':course_code', $course_code, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':session', $session, PDO::PARAM_STR);

            // Execute the statement
            $stmt->execute();

         // Success message with Swalfire alert
        $message = "Exam details added successfully!";
        echo "<script>";
        echo "Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '$message',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'addexam.php';
            }
        });";
        echo "</script>";

        } catch(PDOException $e) {
            $message = "Error adding exam details: " . $e->getMessage();
        } finally {
            // Close the connection (if not closed in the catch block)
            $conn = null;
        }

    } else {
        // Display validation errors
        $message = "Please fix the following errors:";
        $errorList = "<ul>";
        foreach ($errors as $error) {
            $errorList .= "<li>$error</li>";
        }
        $errorList .= "</ul>";
        $message .= $errorList;
    }

    // Display message (either success or error) based on the outcome
    echo $message;

} else {
    // Not a POST request, potentially an error or unexpected access
    echo "Invalid request method.";
}
?>