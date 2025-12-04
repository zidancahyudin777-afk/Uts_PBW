<?php include 'php/koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - MeyDa Collection</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <h1>Input Pelanggan</h1>
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
        <form action="php/simpan_pelanggan.php" method="POST">
            <h2>Tambah Pelanggan Baru</h2>

            <label for="nama_pelanggan">Nama Pelanggan:</label>
            <input type="text" id="nama_pelanggan" name="nama_pelanggan" required placeholder="Masukkan nama lengkap">

            <label for="kontak">Kontak (HP/WA):</label>
            <input type="text" id="kontak" name="kontak" required placeholder="Contoh: 08123456789">

            <button type="submit">Simpan Pelanggan</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 MeyDa Collection</p>
    </footer>

    <script src="js/script.js"></script>
</body>

</html>
