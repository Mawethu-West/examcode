<?php

session_start();
include("includes/db.php");
include("includes/header.php");
include("includes/sidebar.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashmaster.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Exams</title>
</head>
<body>
<div class="main-content">
<main>
    <div class="page-content">
    <div clas="records table-responsive">
    <div class="record-header">
                        <div class="add">
                            <a href="addexam.php"><button>Add Exam</button></a>
                        </div>
                    </div>
        <div>
<table width="100%">
    <thead>
        <tr>
            <th>invigilator:</th>
            <th>course code:</th>
            <th># of candidates:</th>
            <th>date:</th>
        </tr>
    </thead>
    <tbody>
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
 //Query for data collection
$sql="SELECT invigilator, course_code ,No_of_candidates ,date FROM exams";
$result = $conn->query($sql);

//Display results
if($result-> num_rows> 0){
    while ($row = $result-> fetch_assoc()){
        echo"<tr><td>".$row['invigilator']."</td><td>".$row['course_code']."</td><td>".$row['No_of_candidates']."</td><td>".$row['date']."</td></tr>";
    }
    echo "</table>";
}
else {
    echo "no exams found";
}


// Close connection
$conn = null;
?>
    </tbody>
</table>
</div>
</div>
</div>
</main>
</div>
</body>
</html>

