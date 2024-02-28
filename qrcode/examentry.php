<?php

session_start();
include("includes/db.php");
include("includes/header.php");
include("includes/sidebar.php");

?>
<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
$base_url = 'http://localhost/HTML5-QR-CODE-SCANNER-MAIN/app/func/store.php';
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
    <script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Exam Entry</title>
</head>
<body>
    <div class="main-content" style=top 50%>
 <main>
 <div class="page-content">

 <div id="qr-reader" style="width: 100%"></div>
	
    <script>
      const html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { fps: 30, qrbox: 350 });
      let lastScanned;
      let reScan = true;

      const onScanSuccess = async (decodedText, decodedResult) => {
        if (decodedText !== lastScanned) {
          lastScanned = decodedText;
          await console.log(`Code scanned = ${decodedText}`, decodedResult);

          const baseurl = '<?php echo $base_url; ?>';
          const data = {
            'qrcode_values': decodedText,
          };

          const xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
              console.log(xmlhttp.responseText);
              const result = JSON.parse(xmlhttp.responseText);
              const swalConfig = {
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                confirmButtonText: 'Close',
              };

              if (result.status === 'error') {
                swalConfig.icon = 'error';
                swalConfig.title = 'Oops...';
              }
              else{
                swalConfig.icon = 'success';
                swalConfig.title = 'Success!';
                setTimeout(() => {
                                 Swal.close();
                                 }, 1000);
              }
           
              swalConfig.text = result.message;

              Swal.fire(swalConfig).then((result) => {
                if (result.isConfirmed) {
                  console.log("confirmed");
                }
                reScan = true;
                lastScanned = '';
              });
            }
          };

          xmlhttp.open("POST", baseurl, true);
          xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
          xmlhttp.send(JSON.stringify(data));
        }
      };

      html5QrcodeScanner.render(onScanSuccess);

      window.onload = async function(e) { 
        await document.getElementById("qr-reader").firstChild.firstChild.firstChild.remove();
        const el = document.createElement("span");
        el.innerHTML = "QR Code Scanner";
        await document.getElementById("qr-reader").firstChild.firstChild.appendChild(el);
      };
    </script>       
 </div>

</main>



    </div>
</body>
</html>