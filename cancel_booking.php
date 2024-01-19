<?php
session_start();
if (!isset($_SESSION['username'])) {
    
    header("Location: index.php"); // Redirect jika pengguna belum login
    exit();
  }
  
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    // Hapus semua data sesi
    session_unset();
    session_destroy();
    header("Location: index.php"); // Redirect ke halaman utama setelah logout
    exit();
  }
  
  include 'includes/db_connection.php';  
// ... (koneksi ke database dan validasi sesi)

$user_id = $_SESSION['user_id']; // Ambil ID pengguna dari sesi

// Cek apakah ada parameter id di URL
if (isset($_GET['id'])) {
    $booking_id = $_GET['id']; // Ambil nilai id dari URL

    // Query untuk mendapatkan data pesanan berdasarkan id
    $sql_get_booking = "SELECT * FROM bookingan WHERE id = ?";
    $stmt_get_booking = $conn->prepare($sql_get_booking);
    $stmt_get_booking->bind_param("i", $booking_id);
    $stmt_get_booking->execute();
    $result_booking = $stmt_get_booking->get_result();

    if ($result_booking === false) {
        echo "Terjadi kesalahan saat mengambil data pemesanan.";
        // Tambahkan penanganan kesalahan sesuai kebutuhan aplikasi Anda
    }

    // Cek apakah data pesanan ditemukan
    if ($result_booking->num_rows > 0) {
        $row = $result_booking->fetch_assoc(); // Ambil data pesanan dalam bentuk array asosiatif

        // Cek apakah pesanan milik pengguna yang sedang login
        if ($row['user_id'] == $user_id) {
            // Query untuk menghapus data pesanan
            $sql_delete_booking = "DELETE FROM bookingan WHERE id = ?";
            $stmt_delete_booking = $conn->prepare($sql_delete_booking);
            $stmt_delete_booking->bind_param("i", $booking_id);
            $result_delete_booking = $stmt_delete_booking->execute();

            if ($result_delete_booking === false) {
                echo "Terjadi kesalahan saat menghapus data pemesanan.";
                // Tambahkan penanganan kesalahan sesuai kebutuhan aplikasi Anda
            } else {
                // Redirect ke halaman pesanan saya dengan pesan sukses
                header("Location: profiluser.php?message=Data pemesanan berhasil dibatalkan.");
                exit();
            }
        } else {
            echo "Anda tidak memiliki akses untuk membatalkan pesanan ini.";
            exit();
        }
    } else {
        echo "Data pemesanan tidak ditemukan.";
        exit();
    }
} else {
    echo "Parameter id tidak ditemukan.";
    exit();
}
?>
