<?php
// File: /workspace/meyda-collection/menu.php
// Menu utama untuk aplikasi MeyDa Collection

include 'php/cli_functions.php';

function tampilkanMenu() {
    echo "\n========================================\n";
    echo "      SELAMAT DATANG DI MEYDA COLLECTION\n";
    echo "        Sistem Penjualan Pakaian\n";
    echo "========================================\n";
    echo "Silakan pilih menu berikut:\n";
    echo "1. Lihat Katalog Produk\n";
    echo "2. Input Produk Baru\n";
    echo "3. Input Pelanggan Baru\n";
    echo "4. Input Transaksi\n";
    echo "5. Lihat Laporan Transaksi\n";
    echo "6. Keluar\n";
    echo "========================================\n";
}

function pilihMenu($pilihan) {
    switch($pilihan) {
        case 1:
            tampilkanProduk();
            break;
        case 2:
            inputProdukBaru();
            break;
        case 3:
            inputPelangganBaru();
            break;
        case 4:
            inputTransaksi();
            break;
        case 5:
            tampilkanLaporanTransaksi();
            break;
        case 6:
            echo "\nTerima kasih telah menggunakan MeyDa Collection!\n";
            exit();
            break;
        default:
            echo "\nPilihan tidak valid! Silakan pilih antara 1-6.\n";
    }
}

// Loop utama program
while(true) {
    tampilkanMenu();
    echo "Masukkan pilihan Anda (1-6): ";
    
    // Membaca input dari pengguna
    $input = trim(fgets(STDIN));
    
    // Validasi input
    if(is_numeric($input)) {
        $pilihan = (int)$input;
        pilihMenu($pilihan);
    } else {
        echo "\nInput tidak valid! Harap masukkan angka 1-6.\n";
    }
    
    // Tunggu sebelum menampilkan menu lagi
    echo "\nTekan Enter untuk melanjutkan...";
    fgets(STDIN);
}
?>