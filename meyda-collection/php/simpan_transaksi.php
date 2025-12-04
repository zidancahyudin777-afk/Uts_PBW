<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Data Transaksi
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_user = 1; // Default admin/user ID for now
    
    // Data Detail Transaksi (Single product for simplicity as per form structure, but logic supports extension)
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];
    
    // Get Product Price
    $query_harga = "SELECT harga FROM produk WHERE id_produk = '$id_produk'";
    $result_harga = mysqli_query($koneksi, $query_harga);
    $row_harga = mysqli_fetch_assoc($result_harga);
    $harga_satuan = $row_harga['harga'];
    
    $subtotal = $harga_satuan * $jumlah;
    $total_harga = $subtotal; // For single item transaction

    // 1. Insert into transaksi
    $query_transaksi = "INSERT INTO transaksi (id_user, id_pelanggan, total_harga) VALUES ('$id_user', '$id_pelanggan', '$total_harga')";
    
    if (mysqli_query($koneksi, $query_transaksi)) {
        $id_transaksi = mysqli_insert_id($koneksi); // Get the new ID
        
        // 2. Insert into detail_transaksi
        $query_detail = "INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah, subtotal) VALUES ('$id_transaksi', '$id_produk', '$jumlah', '$subtotal')";
        
        if (mysqli_query($koneksi, $query_detail)) {
             echo "<script>alert('Transaksi berhasil disimpan!'); window.location.href='../html/transaksi.html';</script>";
        } else {
            echo "Error Detail: " . $query_detail . "<br>" . mysqli_error($koneksi);
        }
    } else {
        echo "Error Transaksi: " . $query_transaksi . "<br>" . mysqli_error($koneksi);
    }
}
mysqli_close($koneksi);
?>
