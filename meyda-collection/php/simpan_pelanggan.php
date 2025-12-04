<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_pelanggan'];
    $kontak = $_POST['kontak'];

    $stmt = mysqli_prepare($koneksi, "INSERT INTO pelanggan (nama_pelanggan, kontak) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $nama, $kontak);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Data pelanggan berhasil disimpan!'); window.location.href='../pelanggan.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
    
    mysqli_stmt_close($stmt);
}
mysqli_close($koneksi);
?>
