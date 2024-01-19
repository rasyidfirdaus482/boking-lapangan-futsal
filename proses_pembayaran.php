<?php
// Sesuaikan sesuai kebutuhan validasi dan tindakan pembayaran

session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    include 'includes/db_connection.php'; // Sesuaikan path dengan kebutuhan

    $booking_id = $_GET['id'];

    // Lakukan proses pembayaran sesuai kebutuhan (contoh: update status menjadi "Dibayar")
    $sql_update_status = "UPDATE bookingan SET status_bayar = 'Dibayar' WHERE id = ?";
    $stmt_update_status = $conn->prepare($sql_update_status);
    $stmt_update_status->bind_param("i", $booking_id);
    
    if ($stmt_update_status->execute()) {
        // Set session variables for success message and booking status
        $_SESSION['pesan_alert'] = "Pembayaran berhasil, silahkan tunggu status verifikasi.";
        $_SESSION['status_pemesanan'] = 'berhasil';

        // Redirect ke halaman pembayaran setelah pembayaran berhasil
        header("Location: pembayaran.php");
        exit();
    } else {
        $_SESSION['pesan_alert'] = "Gagal melakukan pembayaran.";
        $_SESSION['status_pemesanan'] = 'gagal';
        // Redirect ke halaman pembayaran setelah pembayaran gagal (atau sesuaikan tindakan yang sesuai)
        header("Location: pembayaran.php");
        exit();
    }

    $stmt_update_status->close();
    $conn->close();
} else {
    // Tindakan jika tidak ada ID pesanan yang diberikan
    $_SESSION['pesan_alert'] = "Tidak ada ID pesanan yang diberikan.";
    $_SESSION['status_pemesanan'] = 'gagal';
    // Redirect ke halaman pembayaran setelah kesalahan (atau sesuaikan tindakan yang sesuai)
    header("Location: pembayaran.php");
    exit();
}

