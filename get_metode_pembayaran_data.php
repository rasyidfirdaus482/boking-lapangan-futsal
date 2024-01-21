<?php
// Sertakan file koneksi database
include 'includes/db_connection.php';

// Query untuk mendapatkan data metode pembayaran
$sql_get_metode_pembayaran = "SELECT * FROM metode_pembayaran";
$result_metode_pembayaran = $conn->query($sql_get_metode_pembayaran);

// Inisialisasi array untuk menyimpan data metode pembayaran
$metode_pembayaran_data = array();

// Ambil data metode pembayaran
while ($row_metode_pembayaran = $result_metode_pembayaran->fetch_assoc()) {
    $metode_pembayaran_data[] = $row_metode_pembayaran;
}

// Tutup koneksi database
$conn->close();

// Kembalikan data sebagai respons JSON
header('Content-Type: application/json');
echo json_encode($metode_pembayaran_data);