<?php
session_start();

// Periksa apakah pengguna telah login
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

include 'includes/db_connection.php'; // Sertakan file koneksi database

$user_id = $_SESSION['user_id']; // Ambil ID pengguna dari sesi

// Query untuk mendapatkan semua pesanan pengguna
$sql_get_user_bookings = "SELECT * FROM bookingan WHERE user_id = ?";
$stmt_get_user_bookings = $conn->prepare($sql_get_user_bookings);
$stmt_get_user_bookings->bind_param("i", $user_id);
$stmt_get_user_bookings->execute();
$result_user_bookings = $stmt_get_user_bookings->get_result();

// // Query untuk mendapatkan harga per jam lapangan siang
// $sql_get_harga_per_jam_siang = "SELECT harga_per_jam FROM lapangan WHERE nama_lapangan = 'siang'";
// $stmt_get_harga_per_jam_siang = $conn->prepare($sql_get_harga_per_jam_siang);
// $stmt_get_harga_per_jam_siang->execute();
// $result_harga_per_jam_siang = $stmt_get_harga_per_jam_siang->get_result();

// // Ambil harga per jam lapangan siang
// if ($result_harga_per_jam_siang->num_rows == 1) {
//     $row_harga_per_jam_siang = $result_harga_per_jam_siang->fetch_assoc();
//     $harga_per_jam_siang = $row_harga_per_jam_siang['harga_per_jam']; // Ambil nilai harga per jam dari database
// } else {
//     // Tindakan jika harga per jam tidak ditemukan
//     $harga_per_jam_siang = 0; // Atur nilai default jika tidak ditemukan
// }
// $stmt_get_harga_per_jam_siang->close();

// // Query untuk mendapatkan harga per jam lapangan malam
// $sql_get_harga_per_jam_malam = "SELECT harga_per_jam FROM lapangan WHERE nama_lapangan = 'malam'";
// $stmt_get_harga_per_jam_malam = $conn->prepare($sql_get_harga_per_jam_malam);
// $stmt_get_harga_per_jam_malam->execute();
// $result_harga_per_jam_malam = $stmt_get_harga_per_jam_malam->get_result();

// // Ambil harga per jam lapangan malam
// if ($result_harga_per_jam_malam->num_rows == 1) {
//     $row_harga_per_jam_malam = $result_harga_per_jam_malam->fetch_assoc();
//     $harga_per_jam_malam = $row_harga_per_jam_malam['harga_per_jam']; // Ambil nilai harga per jam dari database
// } else {
//     // Tindakan jika harga per jam tidak ditemukan
//     $harga_per_jam_malam = 0; // Atur nilai default jika tidak ditemukan
// }
// $stmt_get_harga_per_jam_malam->close();
// Query untuk mendapatkan data metode pembayaran
$sql_get_metode_pembayaran = "SELECT * FROM metode_pembayaran";
$result_metode_pembayaran = $conn->query($sql_get_metode_pembayaran);

// Inisialisasi array untuk menyimpan data metode pembayaran
$metode_pembayaran_data = array();

// Ambil data metode pembayaran
while ($row_metode_pembayaran = $result_metode_pembayaran->fetch_assoc()) {
    $metode_pembayaran_data[] = $row_metode_pembayaran;
}

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
                        <th>Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = 1;
                        while ($row = $result_user_bookings->fetch_assoc()):
                            
                        ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td style="text-align: start;">
                            <?php echo 'Tanggal :'. '<b>'. $row['tanggal'] .'</b>'. '<br>' . 'Jam mulai :'.'<b>'. $row['jam_mulai'].'</b>' . '<br>' . 'jam selesai :'.'<b>'. $row['jam_selesai'] .'</b>'. '<br>' .'lapangan :'.'<b>'. $row['jenis_lapangan'].'</b>' ;?>
                        </td>
                        <td><?php echo  $row['status_bayar']; ?></td>
                        <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
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
                            <!-- Tombol Transfer Bank -->
                            <button id="transfer_bank_button" onclick="showMetodePembayaran('transfer_bank')">Transfer
                                Bank</button>

                            <!-- Tombol DANA -->
                            <button id="dana_button" onclick="showMetodePembayaran('dana')">DANA</button>

                            <script>
                            document.getElementById('transfer_bank_button').addEventListener('click', function() {
                                showMetodePembayaran('transfer_bank');
                            });

                            document.getElementById('dana_button').addEventListener('click', function() {
                                showMetodePembayaran('dana');
                            });
                            </script>

                        </td>
                        <td>
                            <?php if ($row['bukti_pembayaran']): ?>
                            <button
                                style="border:none; background-color:#FDC500; height: 43px; border-radius: 5px;margin-top: 10%; "
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Bayar">
                                <a href="proses_pembayaran.php?id=<?php echo $row['id']; ?>"
                                    style="color: white; text-decoration: none; font-size: 15px; font-weight: bold;"><i
                                        class="bi bi-check-square"
                                        style="color: white; border:none; font-size: 20px;"></i>konfir</a>
                            </button>
                            <?php else: ?>
                            <button disabled
                                style="border:none; background-color:#FDC500;height: 43px;  border-radius: 5px; margin-top: 10%; "
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Bayar"><i
                                    class="bi bi-check-square"
                                    style="color: white; border:none; font-size: 20px;"></i>Konfir</button>
                            <?php endif; ?>

                            <?php if ($row['bukti_pembayaran']): ?>
                            <button
                                style="border:none; background-color:#00509D;  height: 43px; border-radius: 5px; margin-top: 10%; "
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Invoice">
                                <a href=" cetak_invoice.php?id=<?php echo $row['id']; ?>" target="_blank"
                                    style="color: white; text-decoration: none; font-size: 15px; font-weight: bold;"><i
                                        class="bi bi-receipt"
                                        style="color: white; border:none; font-size: 20px;"></i>Cetak</a>
                            </button>
                            <?php else: ?>
                            <button disabled
                                style="border:none; background-color:#00509D; height: 43px;  border-radius: 5px; margin-top: 10%;"
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

    <script>
    function showMetodePembayaran(metode) {
        // Ambil data dari server atau gunakan data yang sudah ada
        fetch('get_metode_pembayaran_data.php') // Ganti dengan path yang benar
            .then(response => response.json())
            .then(data => {
                console.log(data); // Tambahkan ini untuk melihat data yang diterima di console
                // Filter data berdasarkan metode pembayaran yang dipilih
                var filteredData = data.filter(item => item.metode === metode);
                console.log('Filtered Data:', filteredData);

                // Tampilkan Sweet Alert dengan detail metode pembayaran
                if (filteredData.length > 0) {
                    var message = '';
                    filteredData.forEach(item => {
                        message += generateMessage(item);
                    }); // Ambil item pertama yang cocok
                    Swal.fire({
                        title: 'Data Metode Pembayaran',
                        html: message,
                        showCloseButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Tutup'
                    });


                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Tidak Ada Data',
                        text: 'Tidak ada data metode pembayaran untuk metode ' + metode,
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }


    // Fungsi untuk menghasilkan pesan HTML dari data metode pembayaran
    // Fungsi untuk menghasilkan pesan HTML dari data metode pembayaran
    // Fungsi untuk menghasilkan pesan HTML dari data metode pembayaran
    // Fungsi untuk menghasilkan pesan HTML dari data metode pembayaran
    // Fungsi untuk menghasilkan pesan HTML dari data metode pembayaran
    // Fungsi untuk menghasilkan pesan HTML dari data metode pembayaran
    // Fungsi untuk menghasilkan pesan HTML dari data metode pembayaran
    // Fungsi untuk menghasilkan pesan HTML dari data metode pembayaran
    // Fungsi untuk menghasilkan pesan HTML dari data metode pembayaran
    function generateMessage(data) {
        var message = '<table>';
        for (var key in data) {
            // Jika kunci adalah QR_CODE_PATH, tampilkan gambar
            if (key === 'qr_code_path' && data[key]) {
                var imagePath = data[key];
                message += '<tr>';
                message += '<td><strong>Kode QR:</strong></td>'; // Ganti label di sini
                message += '<td><img src="' + imagePath +
                    '" alt="QR Code" style="max-width: 300px; max-height: 300px;"></td>';
                message += '</tr>';
            } else {
                // Jika kunci adalah 'metode', lewati iterasi
                if (key === 'metode') {
                    continue;
                }

                // Jika metodenya bukan 'dana', lewati 'nama_dana', 'id', dan 'qr_code_path'
                if (data['metode'] !== 'dana' && (key === 'nama_dana' || key === 'id' || key === 'qr_code_path')) {
                    continue;
                } else if (data['metode'] !== 'transfer_bank' && (key === 'nama_rekening' || key === 'id' || key ===
                        'nomor_rekening' || key === 'nama_bank')) {
                    continue;
                }

                // Logika untuk menetapkan warna latar belakang berdasarkan nama bank
                var backgroundColor = '';
                if (key === 'nama_bank') {
                    if (data['nama_bank'] === 'BNI') {
                        backgroundColor = 'orange';
                        color = 'black'; // Ganti warna untuk BNI
                    } else if (data['nama_bank'] === 'BRI') {
                        backgroundColor = 'blue';
                        color = 'black'; // Ganti warna untuk BRI
                    }
                }

                message += '<tr style="background-color: ' + backgroundColor + ';color: ' + color + ';">';
                message += '<td><strong>' + key.replace('_', ' ').toUpperCase() + ':</strong></td>';
                message += '<td>' + data[key] + '</td>';
                message += '</tr>';
            }
        }
        message += '</table>';
        return message;
    }
    </script>



</body>

</html>