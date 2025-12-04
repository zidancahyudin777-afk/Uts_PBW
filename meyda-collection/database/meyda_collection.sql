-- Database: meyda_collection

-- DDL: Create Database
CREATE DATABASE IF NOT EXISTS meyda_collection;
USE meyda_collection;

-- DDL: Create Tables

-- Table: user
CREATE TABLE IF NOT EXISTS user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100)
);

-- Table: pelanggan
CREATE TABLE IF NOT EXISTS pelanggan (
    id_pelanggan INT AUTO_INCREMENT PRIMARY KEY,
    nama_pelanggan VARCHAR(100) NOT NULL,
    kontak VARCHAR(50)
);

-- Table: kategori_produk
CREATE TABLE IF NOT EXISTS kategori_produk (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL
);

-- Table: produk
CREATE TABLE IF NOT EXISTS produk (
    id_produk INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(100) NOT NULL,
    id_kategori INT,
    harga DECIMAL(10, 2) NOT NULL,
    stok INT NOT NULL,
    gambar VARCHAR(255),
    FOREIGN KEY (id_kategori) REFERENCES kategori_produk(id_kategori)
);

-- Table: transaksi
CREATE TABLE IF NOT EXISTS transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT, -- User yang melayani (opsional)
    id_pelanggan INT,
    tanggal_transaksi DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_harga DECIMAL(10, 2),
    FOREIGN KEY (id_user) REFERENCES user(id_user),
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan)
);

-- Table: detail_transaksi
CREATE TABLE IF NOT EXISTS detail_transaksi (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT,
    id_produk INT,
    jumlah INT NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_transaksi) REFERENCES transaksi(id_transaksi),
    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)
);

-- Table: laporan (Opsional, bisa berupa view atau tabel rekap)
-- Disini kita buat tabel sederhana untuk log laporan jika diperlukan
CREATE TABLE IF NOT EXISTS laporan (
    id_laporan INT AUTO_INCREMENT PRIMARY KEY,
    tanggal_laporan DATE,
    keterangan TEXT
);

-- DML: Insert Dummy Data

-- Insert user
INSERT INTO user (username, password, nama_lengkap) VALUES
('admin', 'admin123', 'Administrator'),
('kasir1', 'kasir123', 'Budi Santoso'),
('kasir2', 'kasir123', 'Siti Aminah');

-- Insert pelanggan
INSERT INTO pelanggan (nama_pelanggan, kontak) VALUES
('Ani Lestari', '081234567890'),
('Budi Darmawan', '089876543210'),
('Citra Kirana', '085678901234');

-- Insert kategori_produk
INSERT INTO kategori_produk (nama_kategori) VALUES
('Baju Pria'),
('Baju Wanita'),
('Aksesoris');

-- Insert produk
INSERT INTO produk (nama_produk, id_kategori, harga, stok, gambar) VALUES
('Kemeja Polos', 1, 150000, 50, 'kemeja.jpg'),
('Gamis Syari', 2, 250000, 30, 'gamis.jpg'),
('Topi Baseball', 3, 75000, 100, 'topi.jpg');

-- Insert transaksi
INSERT INTO transaksi (id_user, id_pelanggan, total_harga) VALUES
(1, 1, 250000),
(2, 2, 150000),
(1, 3, 75000);

-- Insert detail_transaksi
INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah, subtotal) VALUES
(1, 2, 1, 250000),
(2, 1, 1, 150000),
(3, 3, 1, 75000);

-- DCL: Create User & Grant Privileges
-- Note: Adjust 'meyda_user' and 'password' as needed.
CREATE USER IF NOT EXISTS 'meyda_user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON meyda_collection.* TO 'meyda_user'@'localhost';
FLUSH PRIVILEGES;
