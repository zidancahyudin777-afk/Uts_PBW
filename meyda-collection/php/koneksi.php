<?php
$host = "localhost";
$user = "root"; // Default XAMPP user
$pass = "";     // Default XAMPP password (empty)
$db   = "meyda_collection";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
