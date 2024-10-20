<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $barcode = $_POST['barcode'];
    $nama_barang = $_POST['nama_barang'];
    $stok = $_POST['stok'];

    $query = "INSERT INTO barang (barcode, nama_barang, stok) VALUES ('$barcode', '$nama_barang', '$stok')";
    mysqli_query($conn, $query);

    // Redirect ke halaman generate barcode
    header(header: "Location: generate_barcode.php?barcode=$barcode");
    exit;
}
?>

<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="card mb-4">
            <div class="card-header">
                <h2>Tambah Barang</h2>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="barcode">No Item:</label>
                        <div class="input-group">
                            <input type="text" id="barcode" class="form-control" name="barcode" required>
                            <button type="button" id="scan-button" class="btn btn-secondary">Scan</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang:</label>
                        <input type="text" class="form-control" name="nama_barang" required>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok:</label>
                        <input type="number" class="form-control" name="stok" required>
                    </div>
                    <div class="form-group">
                        <label for="barcode-image">Upload Gambar Barcode:</label>
                        <input type="file" id="barcode-image" class="form-control-file" accept="image/*">
                        <button type="button" id="upload-button" class="btn btn-primary mt-2">Deteksi Barcode</button>
                    </div>
                    <button type="submit" name="submit" class="btn btn-success">Tambah Barang</button>
                </form>
            </div>
        </div>

        <div id="interactive" style="width: 100%; height: auto; border: 1px solid black;"></div>
    </div>

    <!-- Script untuk Barcode Scanner -->
    <script>
        document.getElementById('scan-button').addEventListener('click', function() {
            Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: document.querySelector('#interactive')
                },
                decoder: {
                    readers: ["code_128_reader"]
                },
            }, function(err) {
                if (err) {
                    console.log(err);
                    return;
                }
                Quagga.start();
            });

            Quagga.onDetected(function(data) {
                var code = data.codeResult.code;
                document.getElementById('barcode').value = code;
                alert("Barcode detected: " + code);
                Quagga.stop();
            });
        });

        document.getElementById('upload-button').addEventListener('click', function() {
            const input = document.getElementById('barcode-image');
            const file = input.files[0];
            if (!file) {
                alert("Please upload an image file.");
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                const imgElement = new Image();
                imgElement.src = event.target.result;

                document.getElementById('interactive').innerHTML = '';
                document.getElementById('interactive').appendChild(imgElement);

                Quagga.decodeSingle({
                    decoder: {
                        readers: ["code_128_reader"]
                    },
                    locate: true,
                    src: event.target.result
                }, function(result) {
                    if (result && result.codeResult) {
                        document.getElementById('barcode').value = result.codeResult.code;
                        alert("Barcode detected from image: " + result.codeResult.code);
                    } else {
                        alert("No barcode detected.");
                    }
                });
            };
            reader.readAsDataURL(file);
        });
    </script>
</body>
</html>