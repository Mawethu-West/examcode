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
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>QRCode Web Application</title>
	<script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
	<div id="qr-reader" style="width: 100%"></div>
	
    <script>
      const html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { fps: 7, qrbox: 350 });
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
              } else {
                swalConfig.icon = 'success';
                swalConfig.title = 'Gelukt!';
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
</body>
</html>