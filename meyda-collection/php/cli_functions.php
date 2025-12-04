<?php
// File: /workspace/meyda-collection/php/cli_functions.php
// Fungsi-fungsi CLI untuk aplikasi MeyDa Collection

include 'koneksi.php';

// Fungsi untuk menampilkan daftar produk
function tampilkanProduk() {
    global $koneksi;
    
    $query = "SELECT p.id_produk, p.nama_produk, p.harga, p.stok, k.nama_kategori 
              FROM produk p
              JOIN kategori_produk k ON p.id_kategori = k.id_kategori
              ORDER BY p.id_produk DESC";
    
    $result = mysqli_query($koneksi, $query);
    
    echo "\n========================================\n";
    echo "         DAFTAR PRODUK MEYDA COLLECTION\n";
    echo "========================================\n";
    
    if (mysqli_num_rows($result) > 0) {
        printf("%-5s %-30s %-15s %-10s %-20s\n", "ID", "NAMA PRODUK", "HARGA", "STOK", "KATEGORI");
        echo str_repeat("-", 90) . "\n";
        
        while($row = mysqli_fetch_assoc($result)) {
            $harga = "Rp " . number_format($row['harga'], 0, ',', '.');
            printf("%-5s %-30s %-15s %-10s %-20s\n", 
                $row['id_produk'], 
                substr($row['nama_produk'], 0, 28), 
                $harga, 
                $row['stok'], 
                $row['nama_kategori']);
        }
    } else {
        echo "Belum ada produk dalam database.\n";
    }
    echo "========================================\n";
}

// Fungsi untuk input produk baru
function inputProdukBaru() {
    global $koneksi;
    
    echo "\n========================================\n";
    echo "         INPUT PRODUK BARU\n";
    echo "========================================\n";
    
    // Ambil kategori produk
    $query_kategori = "SELECT * FROM kategori_produk ORDER BY nama_kategori";
    $result_kategori = mysqli_query($koneksi, $query_kategori);
    
    echo "Daftar Kategori:\n";
    if (mysqli_num_rows($result_kategori) > 0) {
        while($row = mysqli_fetch_assoc($result_kategori)) {
            echo $row['id_kategori'] . ". " . $row['nama_kategori'] . "\n";
        }
    } else {
        echo "1. Baju Pria\n";
        echo "2. Baju Wanita\n";
        echo "3. Aksesoris\n";
    }
    
    echo "\nMasukkan data produk baru:\n";
    echo "Nama Produk: ";
    $nama_produk = trim(fgets(STDIN));
    
    echo "ID Kategori: ";
    $id_kategori = (int)trim(fgets(STDIN));
    
    echo "Harga: ";
    $harga = (int)trim(fgets(STDIN));
    
    echo "Stok: ";
    $stok = (int)trim(fgets(STDIN));
    
    // Validasi input
    if (empty($nama_produk) || $id_kategori <= 0 || $harga < 0 || $stok < 0) {
        echo "Data tidak valid! Silakan coba lagi.\n";
        return;
    }
    
    // Query untuk menyimpan produk baru
    $stmt = mysqli_prepare($koneksi, "INSERT INTO produk (nama_produk, id_kategori, harga, stok) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "siii", $nama_produk, $id_kategori, $harga, $stok);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "\nProduk berhasil disimpan!\n";
    } else {
        echo "Error: Gagal menyimpan produk - " . mysqli_error($koneksi) . "\n";
    }
    
    mysqli_stmt_close($stmt);
}

// Fungsi untuk input pelanggan baru
function inputPelangganBaru() {
    global $koneksi;
    
    echo "\n========================================\n";
    echo "         INPUT PELANGGAN BARU\n";
    echo "========================================\n";
    
    echo "Masukkan data pelanggan baru:\n";
    echo "Nama Pelanggan: ";
    $nama_pelanggan = trim(fgets(STDIN));
    
    echo "Kontak (HP/WA): ";
    $kontak = trim(fgets(STDIN));
    
    // Validasi input
    if (empty($nama_pelanggan) || empty($kontak)) {
        echo "Data tidak valid! Silakan coba lagi.\n";
        return;
    }
    
    // Query untuk menyimpan pelanggan baru
    $stmt = mysqli_prepare($koneksi, "INSERT INTO pelanggan (nama_pelanggan, kontak) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $nama_pelanggan, $kontak);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "\nPelanggan berhasil disimpan!\n";
    } else {
        echo "Error: Gagal menyimpan pelanggan - " . mysqli_error($koneksi) . "\n";
    }
    
    mysqli_stmt_close($stmt);
}

// Fungsi untuk input transaksi baru
function inputTransaksi() {
    global $koneksi;
    
    echo "\n========================================\n";
    echo "         INPUT TRANSAKSI BARU\n";
    echo "========================================\n";
    
    // Ambil pelanggan
    $query_pelanggan = "SELECT * FROM pelanggan ORDER BY nama_pelanggan";
    $result_pelanggan = mysqli_query($koneksi, $query_pelanggan);
    
    echo "Daftar Pelanggan:\n";
    if (mysqli_num_rows($result_pelanggan) > 0) {
        while($row = mysqli_fetch_assoc($result_pelanggan)) {
            echo $row['id_pelanggan'] . ". " . $row['nama_pelanggan'] . " (" . $row['kontak'] . ")\n";
        }
    } else {
        echo "Belum ada pelanggan dalam database.\n";
        return;
    }
    
    echo "\nPilih ID Pelanggan: ";
    $id_pelanggan = (int)trim(fgets(STDIN));
    
    // Ambil produk
    $query_produk = "SELECT * FROM produk WHERE stok > 0 ORDER BY nama_produk";
    $result_produk = mysqli_query($koneksi, $query_produk);
    
    echo "\nDaftar Produk Tersedia:\n";
    if (mysqli_num_rows($result_produk) > 0) {
        while($row = mysqli_fetch_assoc($result_produk)) {
            $harga = "Rp " . number_format($row['harga'], 0, ',', '.');
            echo $row['id_produk'] . ". " . $row['nama_produk'] . " (" . $harga . ") - Stok: " . $row['stok'] . "\n";
        }
    } else {
        echo "Belum ada produk dalam database atau stok habis.\n";
        return;
    }
    
    echo "\nPilih ID Produk: ";
    $id_produk = (int)trim(fgets(STDIN));
    
    echo "Jumlah Beli: ";
    $jumlah = (int)trim(fgets(STDIN));
    
    // Validasi input
    if ($id_pelanggan <= 0 || $id_produk <= 0 || $jumlah <= 0) {
        echo "Data tidak valid! Silakan coba lagi.\n";
        return;
    }
    
    // Cek stok produk
    $cek_stok_query = "SELECT stok, harga FROM produk WHERE id_produk = ?";
    $cek_stok_stmt = mysqli_prepare($koneksi, $cek_stok_query);
    mysqli_stmt_bind_param($cek_stok_stmt, "i", $id_produk);
    mysqli_stmt_execute($cek_stok_stmt);
    $cek_stok_result = mysqli_stmt_get_result($cek_stok_stmt);
    $produk_data = mysqli_fetch_assoc($cek_stok_result);
    
    if (!$produk_data || $produk_data['stok'] < $jumlah) {
        echo "Stok tidak mencukupi! Stok tersedia: " . ($produk_data ? $produk_data['stok'] : 0) . "\n";
        mysqli_stmt_close($cek_stok_stmt);
        return;
    }
    
    $harga_satuan = $produk_data['harga'];
    $subtotal = $harga_satuan * $jumlah;
    $total_harga = $subtotal;
    $id_user = 1; // Default admin/user ID
    
    // Mulai transaksi
    mysqli_autocommit($koneksi, FALSE);
    
    try {
        // Insert ke tabel transaksi
        $stmt_transaksi = mysqli_prepare($koneksi, "INSERT INTO transaksi (id_user, id_pelanggan, total_harga) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt_transaksi, "iii", $id_user, $id_pelanggan, $total_harga);
        
        if (!mysqli_stmt_execute($stmt_transaksi)) {
            throw new Exception("Gagal menyimpan transaksi utama");
        }
        
        $id_transaksi = mysqli_insert_id($koneksi);
        
        // Insert ke detail transaksi
        $stmt_detail = mysqli_prepare($koneksi, "INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah, subtotal) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt_detail, "iiii", $id_transaksi, $id_produk, $jumlah, $subtotal);
        
        if (!mysqli_stmt_execute($stmt_detail)) {
            throw new Exception("Gagal menyimpan detail transaksi");
        }
        
        // Kurangi stok produk
        $stmt_update_stok = mysqli_prepare($koneksi, "UPDATE produk SET stok = stok - ? WHERE id_produk = ?");
        mysqli_stmt_bind_param($stmt_update_stok, "ii", $jumlah, $id_produk);
        
        if (!mysqli_stmt_execute($stmt_update_stok)) {
            throw new Exception("Gagal mengupdate stok produk");
        }
        
        // Commit transaksi
        mysqli_commit($koneksi);
        echo "\nTransaksi berhasil disimpan!\n";
        echo "ID Transaksi: " . $id_transaksi . "\n";
        echo "Total Harga: Rp " . number_format($total_harga, 0, ',', '.') . "\n";
        
        mysqli_stmt_close($stmt_transaksi);
        mysqli_stmt_close($stmt_detail);
        mysqli_stmt_close($stmt_update_stok);
        
    } catch (Exception $e) {
        // Rollback jika terjadi kesalahan
        mysqli_rollback($koneksi);
        echo "Error: " . $e->getMessage() . "\n";
    }
    
    mysqli_autocommit($koneksi, TRUE);
    mysqli_stmt_close($cek_stok_stmt);
}

// Fungsi untuk menampilkan laporan transaksi
function tampilkanLaporanTransaksi() {
    global $koneksi;
    
    $query = "SELECT t.id_transaksi, t.tanggal_transaksi, p.nama_pelanggan, pr.nama_produk, dt.jumlah, dt.subtotal 
              FROM transaksi t
              JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
              JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
              JOIN produk pr ON dt.id_produk = pr.id_produk
              ORDER BY t.tanggal_transaksi DESC, t.id_transaksi ASC";
    
    $result = mysqli_query($koneksi, $query);
    
    echo "\n========================================\n";
    echo "         LAPORAN TRANSAKSI\n";
    echo "========================================\n";
    
    if (mysqli_num_rows($result) > 0) {
        printf("%-5s %-12s %-20s %-25s %-6s %-12s\n", "ID", "TANGGAL", "PELANGGAN", "PRODUK", "JUMLAH", "SUBTOTAL");
        echo str_repeat("-", 95) . "\n";
        
        while($row = mysqli_fetch_assoc($result)) {
            $subtotal = "Rp " . number_format($row['subtotal'], 0, ',', '.');
            printf("%-5s %-12s %-20s %-25s %-6s %-12s\n", 
                $row['id_transaksi'], 
                $row['tanggal_transaksi'], 
                substr($row['nama_pelanggan'], 0, 18), 
                substr($row['nama_produk'], 0, 23), 
                $row['jumlah'], 
                $subtotal);
        }
    } else {
        echo "Belum ada data transaksi.\n";
    }
    echo "========================================\n";
}
?>