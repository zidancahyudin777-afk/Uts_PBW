<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = $_POST['nama_produk'];
    $id_kategori = $_POST['id_kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    
    // Handle File Upload
    $gambar = "";
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = "../images/";
        $file_name = basename($_FILES["gambar"]["name"]);
        // Rename file to unique name to prevent overwrite
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = uniqid() . "." . $file_extension;
        $target_file = $target_dir . $new_file_name;
        
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $gambar = $new_file_name;
        } else {
            echo "Maaf, terjadi kesalahan saat mengupload gambar.";
        }
    }

    $query = "INSERT INTO produk (nama_produk, id_kategori, harga, stok, gambar) VALUES ('$nama_produk', '$id_kategori', '$harga', '$stok', '$gambar')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data produk berhasil disimpan!'); window.location.href='../php/daftar_produk.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}
mysqli_close($koneksi);
?>
