<?php
$host = "localhost";
$user = "root"; // Default XAMPP user
$pass = "";     // Default XAMPP password (empty)
$db   = "meyda_collection";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset untuk mencegah karakter aneh
mysqli_set_charset($koneksi, "utf8");

// Set timezone untuk menghindari warning
date_default_timezone_set('Asia/Jakarta');
?>
