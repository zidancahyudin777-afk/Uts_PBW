<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include '../php/koneksi.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk='$id'");
    header("Location: produk.php");
}

$query = "SELECT p.*, k.nama_kategori FROM produk p JOIN kategori_produk k ON p.id_kategori = k.id_kategori ORDER BY p.id_produk DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-nav {
            background: #333;
            padding: 10px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-nav a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn-action {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 4px;
            font-size: 0.9em;
        }
        .btn-edit { background-color: #f39c12; }
        .btn-delete { background-color: #e74c3c; }
        .form-container {
            background: #f9f9f9;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="admin-nav">
        <h2>Admin Panel</h2>
        <div>
            <a href="index.php">Dashboard</a>
            <a href="produk.php">Produk</a>
            <a href="../php/tampil_transaksi.php">Laporan</a>
            <a href="../index.php" target="_blank">Lihat Web</a>
            <a href="logout.php" style="color: #ff6b6b;">Logout</a>
        </div>
    </div>

    <main>
        <h2>Manajemen Produk</h2>

        <div class="form-container">
            <h3>Tambah Produk Baru</h3>
            <form action="../php/simpan_produk.php" method="POST" enctype="multipart/form-data">
                <label for="nama_produk">Nama Produk:</label>
                <input type="text" id="nama_produk" name="nama_produk" required placeholder="Nama pakaian/barang" style="width: 100%; margin-bottom: 10px; padding: 5px;">

                <label for="gambar">Gambar Produk:</label>
                <input type="file" id="gambar" name="gambar" accept="image/*" style="width: 100%; margin-bottom: 10px;">

                <label for="id_kategori">Kategori:</label>
                <select id="id_kategori" name="id_kategori" required style="width: 100%; margin-bottom: 10px; padding: 5px;">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="1">Baju Pria</option>
                    <option value="2">Baju Wanita</option>
                    <option value="3">Aksesoris</option>
                </select>

                <label for="harga">Harga (Rp):</label>
                <input type="number" id="harga" name="harga" required min="0" placeholder="Contoh: 150000" style="width: 100%; margin-bottom: 10px; padding: 5px;">

                <label for="stok">Stok Awal:</label>
                <input type="number" id="stok" name="stok" required min="0" placeholder="Jumlah stok" style="width: 100%; margin-bottom: 10px; padding: 5px;">

                <button type="submit" style="background: #27ae60; color: white; padding: 10px 20px; border: none; cursor: pointer;">Simpan Produk</button>
            </form>
        </div>

        <h3>Daftar Produk</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td>
                        <?php if($row['gambar']): ?>
                            <img src="../images/<?php echo $row['gambar']; ?>" width="50">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row['nama_produk']; ?></td>
                    <td><?php echo $row['nama_kategori']; ?></td>
                    <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo $row['stok']; ?></td>
                    <td>
                        <a href="?delete=<?php echo $row['id_produk']; ?>" class="btn-action btn-delete" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
