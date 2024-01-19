<?php
session_start();

// Periksa apakah pengguna telah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect jika pengguna belum login
    exit();
}

include 'includes/db_connection.php'; // Sertakan file koneksi database

$user_id = $_SESSION['user_id']; // Ambil ID pengguna dari sesi

// Query untuk mendapatkan semua pesanan pengguna
$sql_get_user_bookings = "SELECT * FROM bookingan WHERE user_id = ?";
$stmt_get_user_bookings = $conn->prepare($sql_get_user_bookings);
$stmt_get_user_bookings->bind_param("i", $user_id);
$stmt_get_user_bookings->execute();
$result_user_bookings = $stmt_get_user_bookings->get_result();

// Ambil informasi harga per jam (misalnya, dari tabel lapangan)
$id_lapangan = 1; // Ganti dengan ID lapangan yang sesuai
$sql_get_harga_per_jam = "SELECT harga_per_jam FROM lapangan WHERE id = ?";
$stmt_get_harga_per_jam = $conn->prepare($sql_get_harga_per_jam);
$stmt_get_harga_per_jam->bind_param("i", $id_lapangan);
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Pembayaran</title>
    <!-- Tambahkan stylesheet atau styling sesuai kebutuhan -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <!-- Sertakan Sweet Alert CSS -->
</head>

<body>
    <?php include 'navbarpembayaran.php'; ?>
    <!-- Tambahkan header atau navigasi jika diperlukan -->

    <div class="main" style="margin-top: 100px; margin-bottom:100px;">

        <div class="card" style="width: 80%; margin:auto;">
            <h2>PESANAN DAN PEMBAYARAN</h2>
            <?php if ($result_user_bookings->num_rows > 0): ?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <?php if (isset($_SESSION['pesan_alert']) && $_SESSION['status_pemesanan'] === 'berhasil'): ?>
            <script>
            Swal.fire({
                icon: 'success',
                title: 'Pembayaran Berhasil!',
                text: 'Silahkan Tunggu status verifikasi dihalaman profil',
            });
            </script>
            <?php elseif (isset($_SESSION['pesan_alert']) && $_SESSION['status_pemesanan'] === 'gagal'): ?>
            <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?php echo $_SESSION['pesan_alert']; ?>',
            });
            </script>
            <?php endif; ?>
            <?php unset($_SESSION['pesan_alert'], $_SESSION['status_pemesanan']); ?>
            <table border="1" class="table table-hover table-light">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pesanan</th>
                        <th>Status</th>
                        <th>Total Harga</th>
                        <th>Upload Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = 1;
                        while ($row = $result_user_bookings->fetch_assoc()):
                            $jam_mulai = strtotime($row['jam_mulai']);
                            $jam_selesai = strtotime($row['jam_selesai']);
                            $durasi = ($jam_selesai - $jam_mulai) / (60 * 60);
                            $total_harga = $durasi * $harga_per_jam;
                        ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td style="text-align: start;">
                            <?php echo 'Tanggal :'. '<b>'. $row['tanggal'] .'</b>'. '<br>' . 'Jam mulai :'.'<b>'. $row['jam_mulai'].'</b>' . '<br>' . 'jam selesai :'.'<b>'. $row['jam_selesai'] .'</b>'. '<br>' .'lapangan :'.'<b>'. $row['jenis_lapangan'].'</b>' ;?>
                        </td>
                        <td><?php echo  $row['status_bayar']; ?></td>
                        <td><?php echo 'Rp ' . number_format($total_harga, 0, ',', '.'); ?></td>
                        <td>
                            <?php if ($row['bukti_pembayaran']): ?>
                            <span>Sudah diupload</span>
                            <?php else: ?>
                            <form id="uploadForm_<?php echo $row['id']; ?>" action="proses_upload_bukti.php"
                                method="post" enctype="multipart/form-data">
                                <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                <input type="file" name="bukti_pembayaran" accept="image/*">
                                <button type="button" onclick="uploadBukti(<?php echo $row['id']; ?>)"
                                    class="btn btn-success">
                                    <span class="bi bi-upload"></span> Upload
                                </button>
                            </form>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['bukti_pembayaran']): ?>
                            <button style="border:none; background-color:#FDC500; width: 60px; border-radius: 5px; "
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Bayar">
                                <a href="proses_pembayaran.php?id=<?php echo $row['id']; ?>"
                                    style="color: white; text-decoration: none; font-size: 15px; font-weight: bold;"><i
                                        class="bi bi-credit-card-2-back-fill"
                                        style="color: white; border:none; font-size: 20px;"></i>bayar</a>
                            </button>
                            <?php else: ?>
                            <button disabled
                                style="border:none; background-color:#FDC500; width: 60px; border-radius: 5px; "
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Bayar"><i
                                    class="bi bi-credit-card-2-back-fill"
                                    style="color: white; border:none; font-size: 20px;"></i>Bayar</button>
                            <?php endif; ?>

                            <?php if ($row['bukti_pembayaran']): ?>
                            <button style="border:none; background-color:#00509D; width: 60px; border-radius: 5px; "
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Invoice">
                                <a href=" cetak_invoice.php?id=<?php echo $row['id']; ?>" target="_blank"
                                    style="color: white; text-decoration: none; font-size: 15px; font-weight: bold;"><i
                                        class="bi bi-receipt"
                                        style="color: white; border:none; font-size: 20px;"></i>Cetak</a>
                            </button>
                            <?php else: ?>
                            <button disabled
                                style="border:none; background-color:#00509D; width: 60px; border-radius: 5px; "
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Invoice">
                                <a target="_blank"
                                    style="color: white; text-decoration: none; font-size: 15px; font-weight: bold;"><i
                                        class="bi bi-receipt"
                                        style="color: white; border:none; font-size: 20px;"></i>Cetak</a>
                            </button>
                            <?php endif; ?>
                        </td>

                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>Anda belum melakukan pemesanan.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function uploadBukti(id) {
        var formData = new FormData(document.getElementById('uploadForm_' + id));

        fetch("proses_upload_bukti.php", {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Upload Bukti Berhasil!',
                        text: 'Bukti pembayaran berhasil diupload.'
                    }).then((result) => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    </script>

</body>

</html>