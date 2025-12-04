<?php
include 'koneksi.php';

$query = "SELECT t.id_transaksi, t.tanggal_transaksi, p.nama_pelanggan, pr.nama_produk, dt.jumlah, dt.subtotal 
          FROM transaksi t
          JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
          JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
          JOIN produk pr ON dt.id_produk = pr.id_produk
          ORDER BY t.tanggal_transaksi DESC";

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - MeyDa Collection</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Laporan Transaksi</h1>
    </header>
    <nav>
        <a href="../index.php">Home</a>
        <a href="../pelanggan.php">Pelanggan</a>
        <a href="../produk_form.php">Input Produk</a>
        <a href="../produk.php">Katalog Produk</a>
        <a href="../transaksi.php">Transaksi</a>
        <a href="tampil_transaksi.php">Laporan</a>
        <a href="../admin/login.php" style="float: right; background: #555;">Login Admin</a>
    </nav>
    <main>
        <h2>Data Penjualan</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id_transaksi'] . "</td>";
                        echo "<td>" . $row['tanggal_transaksi'] . "</td>";
                        echo "<td>" . $row['nama_pelanggan'] . "</td>";
                        echo "<td>" . $row['nama_produk'] . "</td>";
                        echo "<td>" . $row['jumlah'] . "</td>";
                        echo "<td>Rp " . number_format($row['subtotal'], 2, ',', '.') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Belum ada data transaksi.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 MeyDa Collection</p>
    </footer>
</body>
</html>

<?php
mysqli_close($koneksi);
?>
