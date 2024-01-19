<?php
// Menggunakan koneksi ke database yang sudah dibuat sebelumnya
include 'includes/db_connection.php'; 

// Query untuk mengambil data pemesanan lapangan beserta nama pengguna
$sql = "SELECT bookingan.*, users.username AS nama_pengguna
        FROM bookingan
        INNER JOIN users ON bookingan.user_id = users.id";
$result = $conn->query($sql);

echo "<h3>Informasi Pemesanan Lapangan:</h3>";
if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Nama Pengguna</th><th>Tanggal</th><th>Jam Mulai</th><th>Jam Selesai</th><th>Jenis Lapangan</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['nama_pengguna']}</td>";
        echo "<td>{$row['tanggal']}</td>";
        echo "<td>{$row['jam_mulai']}</td>";
        echo "<td>{$row['jam_selesai']}</td>";
        echo "<td>{$row['jenis_lapangan']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Tidak ada pemesanan saat ini.</p>";
}

// Tutup koneksi ke basis data
$conn->close();
?>
