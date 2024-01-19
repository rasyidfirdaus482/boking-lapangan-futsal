<?php
// Menggunakan koneksi ke database yang sudah dibuat sebelumnya
include 'includes/db_connection.php'; 

// Mendapatkan ID booking yang akan diverifikasi dari parameter URL
$verifikasi_id = $_GET['id'];

// Update status booking menjadi "Terverifikasi" di basis data
$sql_verifikasi = "UPDATE bookingan SET status = 'Terverifikasi' WHERE id = ?";
$stmt_verifikasi = $conn->prepare($sql_verifikasi);
$stmt_verifikasi->bind_param("i", $verifikasi_id);
$stmt_verifikasi->execute();
$stmt_verifikasi->close();

// Redirect kembali ke halaman admin setelah verifikasi
header("Location: halamanadmin.php");
exit();
?>
