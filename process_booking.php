<?php
session_start();

include 'includes/db_connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $tanggal = $_POST["tanggal"];
    $jamMulai = $_POST["jam_mulai"];
    $jamSelesai = $_POST["jam_selesai"];

    date_default_timezone_set('Asia/Jakarta');
    $now = date("Y-m-d H:i:s");

    if (strtotime("$tanggal $jamMulai") < strtotime($now)) {
        $_SESSION['pesan_alert'] = "Waktu pemesanan tidak valid.";
        $_SESSION['status_pemesanan'] = 'gagal';
        header('Location: halamanuser.php');
        exit();
    } else {
        // Menambahkan aturan minimal pemesanan setengah jam
        $jamMulaiDateTime = strtotime("$tanggal $jamMulai");
        $jamSelesaiDateTime = strtotime("$tanggal $jamSelesai");
        $diffInMinutes = ($jamSelesaiDateTime - $jamMulaiDateTime) / 60;

        // Validasi apakah selisih waktu adalah kelipatan setengah jam
        if ($diffInMinutes < 30 || $diffInMinutes % 30 != 0) {
            $_SESSION['pesan_alert'] = "Pemesanan harus berlangsung dalam kelipatan setengah jam.";
            $_SESSION['status_pemesanan'] = 'gagal';
            header('Location: halamanuser.php');
            exit();
        }

       // Menentukan jenis lapangan berdasarkan jam mulai
$jenisLapangan = '';
if ($jamMulai >= '08:00' && $jamMulai <= '18:00') {
    $jenisLapangan = 'siang';
} elseif ($jamMulai >= '18:00' && $jamMulai < '23:00') {
    $jenisLapangan = 'malam';
} else {
    $_SESSION['pesan_alert'] = "Pilihan jam tidak valid untuk pemesanan. pastikan booking di jam buka (08:00 sampai 23:00)";
    $_SESSION['status_pemesanan'] = 'gagal';
    header('Location: halamanuser.php');
    exit();
}

// Mengambil harga per jam dari database berdasarkan jenis lapangan
$sql_get_harga_per_jam = "SELECT harga_per_jam FROM lapangan WHERE nama_lapangan = ?";
$stmt_get_harga_per_jam = $conn->prepare($sql_get_harga_per_jam);
$stmt_get_harga_per_jam->bind_param("s", $jenisLapangan);
$stmt_get_harga_per_jam->execute();
$result_harga_per_jam = $stmt_get_harga_per_jam->get_result();

if ($result_harga_per_jam->num_rows == 1) {
    $row_harga_per_jam = $result_harga_per_jam->fetch_assoc();
    $harga_per_jam = $row_harga_per_jam['harga_per_jam']; // Ambil nilai harga per jam dari database
} else {
    // Tindakan jika harga per jam tidak ditemukan
    $harga_per_jam = 0; // Atur nilai default jika tidak ditemukan
}
$stmt_get_harga_per_jam->close();

// Melakukan pengecekan pemesanan yang sudah ada
// ... (kode pemesanan sebelumnya)

// Menyimpan pemesanan jika belum ada konflik
if ($total_bookings > 0) {
    $_SESSION['pesan_alert'] = "Pemesanan dengan tanggal, jam, dan lapangan yang sama sudah ada.";
    $_SESSION['status_pemesanan'] = 'gagal';
} else {
    // Menghitung total harga
    $durasi = (strtotime($jamSelesai) - strtotime($jamMulai)) / (60 * 60);
    $total_harga = $durasi * $harga_per_jam;

    // Menyimpan pemesanan dan total harga ke database
    $sql_insert_booking = "INSERT INTO bookingan (user_id, tanggal, jam_mulai, jam_selesai, jenis_lapangan, total_harga) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_insert_booking = $conn->prepare($sql_insert_booking);
    $stmt_insert_booking->bind_param("issssd", $userId, $tanggal, $jamMulai, $jamSelesai, $jenisLapangan, $total_harga);

    if ($stmt_insert_booking->execute()) {
        $_SESSION['pesan_alert'] = "Pemesanan berhasil.";
        $_SESSION['status_pemesanan'] = 'berhasil';
        header('location: halamanuser.php');
        exit();
    } else {
        $_SESSION['pesan_alert'] = "Maaf, terjadi kesalahan saat menyimpan pemesanan.";
        $_SESSION['status_pemesanan'] = 'gagal';
    }
}
header('Location: halamanuser.php');
exit();
    }
}
$conn->close();
?>