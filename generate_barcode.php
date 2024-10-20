<?php
require 'vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;

// Ambil barcode dari URL (misal dari daftar barang)
if (isset($_GET['barcode'])) {
    $barcode = $_GET['barcode'];

    $generator = new BarcodeGeneratorPNG();
    $barcodeImage = $generator->getBarcode($barcode, $generator::TYPE_CODE_128);

    // Tentukan header sebagai image PNG
    header('Content-Type: image/png');
    echo $barcodeImage;
} else {
    echo "Barcode tidak ditemukan.";
}
?>