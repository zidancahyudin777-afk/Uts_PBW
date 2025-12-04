<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_pelanggan'];
    $kontak = $_POST['kontak'];

    $query = "INSERT INTO pelanggan (nama_pelanggan, kontak) VALUES ('$nama', '$kontak')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data pelanggan berhasil disimpan!'); window.location.href='../html/pelanggan.html';</script>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}
mysqli_close($koneksi);
?>
