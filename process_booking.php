<?php
session_start();

include 'includes/db_connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $tanggal = $_POST["tanggal"];
    $jamMulai = $_POST["jam_mulai"];
    $jamSelesai = $_POST["jam_selesai"];
    $jenisLapangan = $_POST["jenis_lapangan"];

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
    $sql_check_booking = "SELECT COUNT(*) as total 
                     FROM bookingan 
                     WHERE tanggal = ? 
                     AND jenis_lapangan = ? 
                     AND ((jam_mulai <= ? AND jam_selesai > ?) OR (jam_mulai < ? AND jam_selesai >= ?))";

$stmt_check_booking = $conn->prepare($sql_check_booking);
$stmt_check_booking->bind_param("ssssss", $tanggal, $jenisLapangan, $jamMulai, $jamMulai, $jamSelesai, $jamSelesai);
$stmt_check_booking->execute();
$result_check_booking = $stmt_check_booking->get_result();
$row = $result_check_booking->fetch_assoc();
$total_bookings = $row['total'];


    if ($total_bookings > 0) {
        $_SESSION['pesan_alert'] = "Pemesanan dengan tanggal, jam, dan lapangan yang sama sudah ada.";
        $_SESSION['status_pemesanan'] = 'gagal';
    } else {
        $sql_get_user_id = "SELECT id FROM users WHERE username = ?";
        $stmt_get_user_id = $conn->prepare($sql_get_user_id);
        $stmt_get_user_id->bind_param("s", $username);
        $stmt_get_user_id->execute();
        $result_get_user_id = $stmt_get_user_id->get_result();

        if ($result_get_user_id->num_rows == 1) {
            $row = $result_get_user_id->fetch_assoc();
            $userId = $row['id'];
           

            $sql_insert_booking = "INSERT INTO bookingan (user_id, tanggal, jam_mulai, jam_selesai, jenis_lapangan) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert_booking = $conn->prepare($sql_insert_booking);
            $stmt_insert_booking->bind_param("issss", $userId, $tanggal, $jamMulai, $jamSelesai, $jenisLapangan);

            if ($stmt_insert_booking->execute()) {
                $_SESSION['pesan_alert'] = "Pemesanan berhasil.";
                $_SESSION['status_pemesanan'] = 'berhasil'; // Atur status pemesanan di sini
                header('location: halamanuser.php');
                exit();
            } else {
                $_SESSION['pesan_alert'] = "Maaf, terjadi kesalahan saat menyimpan pemesanan.";
                $_SESSION['status_pemesanan'] = 'gagal'; // Atur status pemesanan di sini
            }
        } else {
            $pesan_alert = "Pengguna tidak ditemukan.";
        }
    }
    header('Location: halamanuser.php');
    exit();
}
}
$conn->close();