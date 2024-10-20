<?php
// Include koneksi ke database
include 'db.php'; 

// Autoload PHPSpreadsheet
require 'vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Query untuk mengambil data dari database
$query = "SELECT * FROM barang";
$result = mysqli_query($conn, $query);

// Membuat objek Spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menambahkan header kolom
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Barcode');
$sheet->setCellValue('C1', 'Nama Barang');
$sheet->setCellValue('D1', 'Stok');

// Mengisi data dari database ke dalam Excel
$row = 2; // Mulai dari baris kedua setelah header
while ($data = mysqli_fetch_array($result)) {
    $sheet->setCellValue('A' . $row, $data['id']);
    $sheet->setCellValue('B' . $row, $data['barcode']);
    $sheet->setCellValue('C' . $row, $data['nama_barang']);
    $sheet->setCellValue('D' . $row, $data['stok']);
    $row++;
}

// Atur nama file dan tipe file untuk download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="stok_barang.xlsx"');
header('Cache-Control: max-age=0');

// Menulis file Excel dan mengirimkan output ke browser
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
``