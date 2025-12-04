<?php 
include 'php/koneksi.php';

// Fetch customers for dropdown
$query_pelanggan = "SELECT * FROM pelanggan ORDER BY nama_pelanggan";
$result_pelanggan = mysqli_query($koneksi, $query_pelanggan);

// Fetch products for dropdown
$query_produk = "SELECT * FROM produk WHERE stok > 0 ORDER BY nama_produk";
$result_produk = mysqli_query($koneksi, $query_produk);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi - MeyDa Collection</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <h1>Input Transaksi</h1>
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
        <form action="php/simpan_transaksi.php" method="POST">
            <h2>Tambah Transaksi Baru</h2>

            <label for="id_pelanggan">Pilih Pelanggan:</label>
            <select id="id_pelanggan" name="id_pelanggan" required>
                <option value="">-- Pilih Pelanggan --</option>
                <?php
                if (mysqli_num_rows($result_pelanggan) > 0) {
                    while($row = mysqli_fetch_assoc($result_pelanggan)) {
                        echo "<option value='" . $row['id_pelanggan'] . "'>" . $row['nama_pelanggan'] . "</option>";
                    }
                } else {
                    // Fallback if no customers in database
                    echo "<option value='1'>Ani Lestari</option>";
                    echo "<option value='2'>Budi Darmawan</option>";
                    echo "<option value='3'>Citra Kirana</option>";
                }
                ?>
            </select>

            <label for="id_produk">Pilih Produk:</label>
            <select id="id_produk" name="id_produk" required>
                <option value="">-- Pilih Produk --</option>
                <?php
                if (mysqli_num_rows($result_produk) > 0) {
                    while($row = mysqli_fetch_assoc($result_produk)) {
                        $harga_format = number_format($row['harga'], 0, ',', '.');
                        echo "<option value='" . $row['id_produk'] . "'>" . $row['nama_produk'] . " (Rp " . $harga_format . ")</option>";
                    }
                } else {
                    // Fallback if no products in database
                    echo "<option value='1'>Kemeja Polos (Rp 150.000)</option>";
                    echo "<option value='2'>Gamis Syari (Rp 250.000)</option>";
                    echo "<option value='3'>Topi Baseball (Rp 75.000)</option>";
                }
                ?>
            </select>

            <label for="jumlah">Jumlah Beli:</label>
            <input type="number" id="jumlah" name="jumlah" required min="1" value="1">

            <button type="submit">Simpan Transaksi</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 MeyDa Collection</p>
    </footer>

    <script src="js/script.js"></script>
</body>

</html>
