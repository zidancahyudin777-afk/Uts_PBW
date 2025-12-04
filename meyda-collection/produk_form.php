<?php 
include 'php/koneksi.php';

// Fetch categories for dropdown
$query_kategori = "SELECT * FROM kategori_produk ORDER BY nama_kategori";
$result_kategori = mysqli_query($koneksi, $query_kategori);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk - MeyDa Collection</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <h1>Input Produk</h1>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="pelanggan.php">Pelanggan</a>
        <a href="produk_form.php">Input Produk</a>
        <a href="produk.php">Katalog Produk</a>
        <a href="transaksi.php">Transaksi</a>
        <a href="php/tampil_transaksi.php">Laporan</a>
        <a href="admin/login.php" style="float: right; background: #555;">Login Admin</a>
    </nav>

    <main>
        <form action="php/simpan_produk.php" method="POST" enctype="multipart/form-data">
            <h2>Tambah Produk Baru</h2>

            <label for="nama_produk">Nama Produk:</label>
            <input type="text" id="nama_produk" name="nama_produk" required placeholder="Nama pakaian/barang">

            <label for="gambar">Gambar Produk:</label>
            <input type="file" id="gambar" name="gambar" accept="image/*">

            <label for="id_kategori">Kategori:</label>
            <select id="id_kategori" name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <?php
                if (mysqli_num_rows($result_kategori) > 0) {
                    while($row = mysqli_fetch_assoc($result_kategori)) {
                        echo "<option value='" . $row['id_kategori'] . "'>" . $row['nama_kategori'] . "</option>";
                    }
                } else {
                    // Fallback if no categories in database
                    echo "<option value='1'>Baju Pria</option>";
                    echo "<option value='2'>Baju Wanita</option>";
                    echo "<option value='3'>Aksesoris</option>";
                }
                ?>
            </select>

            <label for="harga">Harga (Rp):</label>
            <input type="number" id="harga" name="harga" required min="0" placeholder="Contoh: 150000">

            <label for="stok">Stok Awal:</label>
            <input type="number" id="stok" name="stok" required min="0" placeholder="Jumlah stok">

            <button type="submit">Simpan Produk</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 MeyDa Collection</p>
    </footer>

    <script src="js/script.js"></script>
</body>

</html>
