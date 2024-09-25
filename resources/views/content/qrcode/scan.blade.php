<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</head>
<body>
    <div style="text-align: center;">
        <h1>Scan QR Code</h1>
        <video id="preview" width="400" height="300"></video>
        <p id="scan-result">Result: <span id="qr-result"></span></p>
    </div>

    <script type="text/javascript">
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        scanner.addListener('scan', function (content) {
            console.log(content);
            document.getElementById('qr-result').textContent = content;
        });

        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
                alert('No cameras found.');
            }
        }).catch(function (e) {
            console.error(e);
        });
    </script>
</body>
</html>

{{-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Scanner</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
</head>
<body>
    <div style="text-align: center;">
        <h1>Scan Barcode</h1>
        <div id="interactive" class="viewport"></div>
        <p id="scan-result">Result: <span id="barcode-result"></span></p>
    </div>

    <script type="text/javascript">
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#interactive')    // Or '#yourElement' (optional)
            },
            decoder: {
                readers: ["code_128_reader", "ean_reader", "ean_8_reader", "upc_reader", "upc_e_reader"] // Specify barcode formats you want to read
            }
        }, function (err) {
            if (err) {
                console.log(err);
                return;
            }
            console.log("Initialization finished. Ready to start");
            Quagga.start();
        });

        Quagga.onDetected(function(data) {
            let code = data.codeResult.code;
            console.log("Barcode detected:", code);
            document.getElementById('barcode-result').textContent = code;
        });
    </script>
</body>
</html>
 --}}
