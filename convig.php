<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_pondok"; // <--- UBAH INI SESUAI NAMA DATABASE ANDA

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>