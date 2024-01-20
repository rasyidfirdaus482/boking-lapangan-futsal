<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect jika pengguna belum login
    exit();
}

include 'includes/db_connection.php';

$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    $sql_get_booking = "SELECT * FROM bookingan WHERE id = ?";
    $stmt_get_booking = $conn->prepare($sql_get_booking);
    $stmt_get_booking->bind_param("i", $booking_id);
    $stmt_get_booking->execute();
    $result_booking = $stmt_get_booking->get_result();

    if ($result_booking === false) {
        echo "Terjadi kesalahan saat mengambil data pemesanan.";
        exit();
    }

    if ($result_booking->num_rows > 0) {
        $row = $result_booking->fetch_assoc();

        if ($row['user_id'] == $user_id) {
            $tanggal = $row['tanggal'];
            $jam_mulai = $row['jam_mulai'];
            $jam_selesai = $row['jam_selesai'];
            $jenis_lapangan = $row['jenis_lapangan'];

            

            // Cek apakah form edit telah disubmit
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                // Ambil data dari form edit
                $tanggal = $_POST['tanggal'];
                $jam_mulai = $_POST['jam_mulai'];
                $jam_selesai = $_POST['jam_selesai'];

                // Validasi data form
                // Tambahkan validasi sesuai kebutuhan aplikasi Anda
                // Misalnya, cek apakah tanggal dan jam sudah sesuai dengan format, cek apakah lapangan tersedia, dll.

                // Validasi jam tutup
                $jam_tutup = '08:00';

                if ($jam_mulai >= '00:00' && $jam_mulai < $jam_tutup) {
                    echo "Pemesanan tidak dapat dimulai pada jam tutup.";
                    exit();
                }

                if ($jam_selesai > '00:00' && $jam_selesai <= $jam_tutup) {
                    echo "Pemesanan tidak dapat dilakukan melewati jam tutup.";
                    exit();
                }

                // Tentukan jenis lapangan berdasarkan jam_mulai
                if ($jam_mulai >= '08:00' && $jam_mulai < '18:00') {
                    $jenis_lapangan = 'siang';
                } elseif ($jam_mulai >= '18:00' && $jam_mulai < '23:00') {
                    $jenis_lapangan = 'malam';
                } else {
                    // Tindakan jika jam_mulai tidak valid
                    echo "Jam_mulai tidak valid.";
                    exit();
                }
                // Query untuk mendapatkan harga per jam berdasarkan jenis lapangan
            $sql_get_harga_per_jam = "SELECT harga_per_jam FROM lapangan WHERE nama_lapangan = ?";
            $stmt_get_harga_per_jam = $conn->prepare($sql_get_harga_per_jam);
            $stmt_get_harga_per_jam->bind_param("s", $jenis_lapangan);
            $stmt_get_harga_per_jam->execute();
            $result_harga_per_jam = $stmt_get_harga_per_jam->get_result();

            if ($result_harga_per_jam->num_rows == 1) {
                $row_harga_per_jam = $result_harga_per_jam->fetch_assoc();
                $harga_per_jam = $row_harga_per_jam['harga_per_jam'];

                $durasi = (strtotime($jam_selesai) - strtotime($jam_mulai)) / (60 * 60);
                $total_harga = $durasi * $harga_per_jam;

                // Update total_harga ke dalam database
                $sql_update_total_harga = "UPDATE bookingan SET total_harga = ? WHERE id = ?";
                $stmt_update_total_harga = $conn->prepare($sql_update_total_harga);
                $stmt_update_total_harga->bind_param("di", $total_harga, $booking_id);
                $stmt_update_total_harga->execute();

                if ($stmt_update_total_harga->affected_rows > 0) {
                    // Berhasil memperbarui total harga
                } else {
                    echo "Gagal memperbarui total harga.";
                }
                $stmt_update_total_harga->close();
            } else {
                echo "Harga per jam tidak ditemukan.";
            }
            $stmt_get_harga_per_jam->close();
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
                $stmt_update_booking->close();
            }
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
            <button type="submit" name="submit" value="Simpan">Simpan</button>
        </p>
    </form>

    <a href="profiluser.php">Kembali ke Profil Saya</a>

    <script src="js/script.js"></script>
</body>

</html>