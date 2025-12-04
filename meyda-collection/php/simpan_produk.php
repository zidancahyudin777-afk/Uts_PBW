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

    // Use prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($koneksi, "INSERT INTO produk (nama_produk, id_kategori, harga, stok, gambar) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "siiis", $nama_produk, $id_kategori, $harga, $stok, $gambar);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Data produk berhasil disimpan!'); window.location.href='../produk.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
    
    mysqli_stmt_close($stmt);
}
mysqli_close($koneksi);
?>
