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
            // Simpan data pesanan ke dalam variabel
            $tanggal = $row['tanggal'];
            $jam_mulai = $row['jam_mulai'];
            $jam_selesai = $row['jam_selesai'];
            $jenis_lapangan = $row['jenis_lapangan'];
        } else {
            echo "Anda tidak memiliki akses untuk mengedit pesanan ini.";
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

// Cek apakah form edit telah disubmit
if (isset($_POST['submit'])) {
    // Ambil data dari form edit
    $tanggal = $_POST['tanggal'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $jenis_lapangan = $_POST['jenis_lapangan'];

    // Validasi data form
    // Tambahkan validasi sesuai kebutuhan aplikasi Anda
    // Misalnya, cek apakah tanggal dan jam sudah sesuai dengan format, cek apakah lapangan tersedia, dll.

    // Query untuk update data pesanan
    $sql_update_booking = "UPDATE bookingan SET tanggal = ?, jam_mulai = ?, jam_selesai = ?, jenis_lapangan = ? WHERE id = ?";
    $stmt_update_booking = $conn->prepare($sql_update_booking);
    $stmt_update_booking->bind_param("ssssi", $tanggal, $jam_mulai, $jam_selesai, $jenis_lapangan, $booking_id);
    $result_update_booking = $stmt_update_booking->execute();

    if ($result_update_booking === false) {
        echo "Terjadi kesalahan saat mengupdate data pemesanan.";
        // Tambahkan penanganan kesalahan sesuai kebutuhan aplikasi Anda
    } else {
        // Redirect ke halaman pesanan saya dengan pesan sukses
        header("Location: profiluser.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Pesanan</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Edit Pesanan</h1>

    <form action="" method="post">
        <p>
            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" id="tanggal" value="<?php echo $tanggal; ?>" required>
        </p>
        <p>
            <label for="jam_mulai">Jam Mulai:</label>
            <input type="time" name="jam_mulai" id="jam_mulai" value="<?php echo $jam_mulai; ?>" required>
        </p>
        <p>
            <label for="jam_selesai">Jam Selesai:</label>
            <input type="time" name="jam_selesai" id="jam_selesai" value="<?php echo $jam_selesai; ?>" required>
        </p>
        <p>
            <label for="jenis_lapangan">Jenis Lapangan:</label>
            <select name="jenis_lapangan" id="jenis_lapangan" required>
                <option value="A" <?php if ($jenis_lapangan == "Sintetis") echo "selected"; ?>>A</option>
                <option value="B" <?php if ($jenis_lapangan == "Vinyl") echo "selected"; ?>>B</option>
               
            </select>
        </p>
        <p>
           <button type="submit" name="submit" value="Simpan">Simpan</button>
        </p>
    </form>

    <a href="pesanan_saya.php">Kembali ke Pesanan Saya</a>

    <script src="js/script.js"></script>
</body>
</html>
