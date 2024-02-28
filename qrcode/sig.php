<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGNATURE PAGE</title>
    <link rel="stylesheet" href="css/sig.css">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
     <form class="signature-pad-form" id="signature-pad-form" action="submit.php" method="POST">
       <h1>Exam Clockout</h1>
       <p>use your signature to exit</p>

       <p><b>SIGNATURE:</b></p>
       <div class="middle-canvas">
       <canvas height="200" width="400" class="signature-pad"></canvas>
       <p><a href="#"class="clear-button">CLEAR</a></p>

<button class="submit-button"type="submit">SUBMIT</button>
      </div>
    </form>
    <script src="sig.js"></script>
</body>
</html>