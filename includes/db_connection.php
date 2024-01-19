<?php
$servername = "localhost"; // Ganti dengan nama server Anda
$username = "root"; // Ganti dengan username basis data Anda
$password = ""; // Ganti dengan password basis data Anda
$dbname = "booking"; // Ganti dengan nama basis data Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
