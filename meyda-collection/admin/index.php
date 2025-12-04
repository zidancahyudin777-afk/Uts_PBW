<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include '../php/koneksi.php';

// Hitung total data untuk dashboard
$total_produk = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM produk"));
$total_transaksi = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM transaksi"));
$total_pelanggan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pelanggan"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - MeyDa Collection</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .dashboard-card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .dashboard-card h3 {
            margin: 0;
            color: #555;
        }
        .dashboard-card p {
            font-size: 2em;
            font-weight: bold;
            color: #333;
            margin: 10px 0 0;
        }
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
        .welcome-msg {
            margin: 20px 0;
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
        <div class="welcome-msg">
            <h2>Selamat Datang, <?php echo $_SESSION['nama_lengkap']; ?>!</h2>
            <p>Anda login sebagai <strong><?php echo $_SESSION['username']; ?></strong>.</p>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Total Produk</h3>
                <p><?php echo $total_produk; ?></p>
            </div>
            <div class="dashboard-card">
                <h3>Total Transaksi</h3>
                <p><?php echo $total_transaksi; ?></p>
            </div>
            <div class="dashboard-card">
                <h3>Total Pelanggan</h3>
                <p><?php echo $total_pelanggan; ?></p>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 MeyDa Collection - Admin Panel</p>
    </footer>
</body>
</html>
