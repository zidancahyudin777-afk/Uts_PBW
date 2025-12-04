<?php
include 'koneksi.php';

$query = "SELECT p.id_produk, p.nama_produk, p.harga, p.stok, p.gambar, k.nama_kategori 
          FROM produk p
          JOIN kategori_produk k ON p.id_kategori = k.id_kategori
          ORDER BY p.id_produk DESC";

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - MeyDa Collection</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background-color: #eee;
        }
        .product-info {
            padding: 15px;
        }
        .product-price {
            color: #27ae60;
            font-weight: bold;
            font-size: 1.2em;
        }
        .product-category {
            color: #7f8c8d;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <header>
        <h1>Katalog Produk</h1>
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
        <h2>Koleksi Terbaru</h2>
        <div class="product-grid">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $gambar = !empty($row['gambar']) ? "../images/" . $row['gambar'] : "https://via.placeholder.com/250x200?text=No+Image";
                    ?>
                    <div class="product-card">
                        <img src="<?php echo $gambar; ?>" alt="<?php echo $row['nama_produk']; ?>" class="product-image">
                        <div class="product-info">
                            <h3><?php echo $row['nama_produk']; ?></h3>
                            <p class="product-category"><?php echo $row['nama_kategori']; ?></p>
                            <p class="product-price">Rp <?php echo number_format($row['harga'], 2, ',', '.'); ?></p>
                            <p>Stok: <?php echo $row['stok']; ?></p>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>Belum ada produk.</p>";
            }
            ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 MeyDa Collection</p>
    </footer>
</body>
</html>

<?php
mysqli_close($koneksi);
?>
