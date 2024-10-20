// update_stok.php
<?php
include 'db.php'; // koneksi database

if (isset($_POST['update_stok'])) {
    $id = $_POST['id'];
    $stok_baru = $_POST['stok'];

    $query = "UPDATE barang SET stok = '$stok_baru' WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        echo "Stok barang berhasil diupdate";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>