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
    $stmt_harga = mysqli_prepare($koneksi, "SELECT harga FROM produk WHERE id_produk = ?");
    mysqli_stmt_bind_param($stmt_harga, "i", $id_produk);
    mysqli_stmt_execute($stmt_harga);
    $result_harga = mysqli_stmt_get_result($stmt_harga);
    $row_harga = mysqli_fetch_assoc($result_harga);
    $harga_satuan = $row_harga['harga'];
    
    $subtotal = $harga_satuan * $jumlah;
    $total_harga = $subtotal; // For single item transaction

    // 1. Insert into transaksi
    $stmt_transaksi = mysqli_prepare($koneksi, "INSERT INTO transaksi (id_user, id_pelanggan, total_harga) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt_transaksi, "iii", $id_user, $id_pelanggan, $total_harga);
    
    if (mysqli_stmt_execute($stmt_transaksi)) {
        $id_transaksi = mysqli_insert_id($koneksi); // Get the new ID
        
        // 2. Insert into detail_transaksi
        $stmt_detail = mysqli_prepare($koneksi, "INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah, subtotal) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt_detail, "iiii", $id_transaksi, $id_produk, $jumlah, $subtotal);
        
        if (mysqli_stmt_execute($stmt_detail)) {
             echo "<script>alert('Transaksi berhasil disimpan!'); window.location.href='../transaksi.php';</script>";
        } else {
            echo "Error Detail: " . mysqli_error($koneksi);
        }
        mysqli_stmt_close($stmt_detail);
    } else {
        echo "Error Transaksi: " . mysqli_error($koneksi);
    }
    
    mysqli_stmt_close($stmt_harga);
    mysqli_stmt_close($stmt_transaksi);
}
mysqli_close($koneksi);
?>
