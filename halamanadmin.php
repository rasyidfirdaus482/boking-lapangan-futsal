<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect jika bukan admin
    exit();
}

include 'includes/db_connection.php';

date_default_timezone_set("Asia/Jakarta");
$tanggal_sekarang = date("Y-m-d"); // Change format to match the database format

$sql_cek_booking = "SELECT * FROM bookingan WHERE tanggal < ?";
$stmt_cek_booking = $conn->prepare($sql_cek_booking);
$stmt_cek_booking->bind_param("s", $tanggal_sekarang);
$stmt_cek_booking->execute();
$result_cek_booking = $stmt_cek_booking->get_result();

while ($row_cek_booking = $result_cek_booking->fetch_assoc()) {
    $sql_hapus_booking = "DELETE FROM bookingan WHERE id = ?";
    $stmt_hapus_booking = $conn->prepare($sql_hapus_booking);
    $stmt_hapus_booking->bind_param("i", $row_cek_booking['id']);
    $stmt_hapus_booking->execute();
    $stmt_hapus_booking->close();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['hapus'])) {
    $hapus_id = $_GET['hapus'];
    $sql_hapus_booking = "DELETE FROM bookingan WHERE id = ?";
    $stmt_hapus_booking = $conn->prepare($sql_hapus_booking);
    $stmt_hapus_booking->bind_param("i", $hapus_id);
    $stmt_hapus_booking->execute();
    $stmt_hapus_booking->close();
    header("Location: halamanadmin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

$sql_get_all_bookings = "SELECT bookingan.*, users.username AS nama_pemesan
                         FROM bookingan
                         INNER JOIN users ON bookingan.user_id = users.id";
$result_all_bookings = $conn->query($sql_get_all_bookings);

if ($result_all_bookings === false) {
    echo "Terjadi kesalahan saat mengambil data pemesanan.";
    // Tambahkan penanganan kesalahan sesuai kebutuhan aplikasi Anda
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css"><!-- Sesuaikan dengan lokasi berkas CSS Anda -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
    /* Gaya untuk modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        overflow: auto;

    }

    /* Gaya untuk tombol keluar */
    .close {
        color: black;
        font-size: 50px;
        /* Sesuaikan ukuran font jika diinginkan */
        font-weight: bold;
        position: absolute;
        top: px;
        right: 30px;
        padding: 0px;
        /* Sesuaikan sesuai kebutuhan */
        cursor: pointer;
        background-color: red;
        border-radius: 5px;
        width: 60px;
        height: auto;



    }

    /* Gaya untuk tombol "Lihat Gambar Penuh" */
    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    </style>


</head>

<body>
    <header>
        <li>
            <h3>Admin Dashboard</h3>
        </li>
        <nav>

            <li>Selamat datang, <?php echo $_SESSION['username']; ?></li>
            <li>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="submit" name="logout" value="Logout">
                </form>
            </li>
        </nav>
        <div class="utama" style="margin-top: -15px; z-index: 1;">
            <?php include 'menu.php'; ?>
        </div>
    </header>

    <div class="kedua">
        <?php
    
if(!empty($_GET['modul']))
{
  if(file_exists("modul/$_GET[modul].php"))
  { 
  include("modul/$_GET[modul].php");
  } else 
  {
  echo "<h2>Error !<br/>Halaman Tidak Di Temukan !</h2>";
  }
} else 
{ 
?>


        <h2>Daftar Booking</h2>

        <div id="lapangan-info">
            <?php if ($result_all_bookings->num_rows > 0): ?>
            <table border=" 1" class="table table-hover table-light">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Jenis Lapangan</th>
                        <th>Nama Pemesan</th>
                        <th>Status Bayar</th>
                        <th>Status</th>
                        <th>bukti bayar</th>
                        <th>Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_all_bookings->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['tanggal']; ?></td>
                        <td><?php echo $row['jam_mulai']; ?></td>
                        <td><?php echo $row['jam_selesai']; ?></td>
                        <td><?php echo $row['jenis_lapangan']; ?></td>
                        <td><?php echo $row['nama_pemesan']; ?></td>
                        <td><?php echo $row['status_bayar']; ?></td>
                        <td><?php echo $row['status']; ?></td>


                        <td>
                            <script>
                            function showFullImage(imagePath) {
                                Swal.fire({
                                    imageUrl: imagePath,
                                    imageAlt: 'Bukti Pembayaran',
                                    showCloseButton: true,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Tutup'
                                });
                            }
                            </script>

                            <?php
    // Assuming $row['bukti_pembayaran'] contains the file name
    $imagePath = $row['bukti_pembayaran'];
    ?>
                            <img src="<?php echo $imagePath; ?>" alt="Bukti Pembayaran" width="100" height="100">
                            <!-- Tombol "Lihat Gambar Penuh" -->
                            <button onclick="showFullImage('<?php echo $imagePath; ?>')"
                                style="width: 40px; height: 40px; float:right; margin-top: 0px; border-radius:10%; background-color: #FFA500;">
                                <i class="bi bi-eye-fill" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Lihat Bukti"></i>
                            </button>


                            <!-- Modal (awalnya tidak ditampilkan) -->
                            <div id="imageModal" class="modal">
                                <span class="close" onclick="closeModal()">&times;</span>
                                <img id="fullImage" src="" alt="Bukti Pembayaran" width="100%" height="100%">
                            </div>
                        </td>

                        <td>


                            <a href="verifikasi_booking.php?id=<?php echo $row['id']; ?>">
                                <button class="bi bi-person-check"
                                    style="border-radius: 10%; height: 40px;background-color:#00BFFF;"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Verifikasi booking">
                                </button>
                            </a>
                            <a href="halamanadmin.php?hapus=<?php echo $row['id']; ?>">
                                <button class="bi bi-trash"
                                    style="border-radius: 10%; height: 40px; background-color:red;"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus booking">
                                </button>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <script>
            $(document).ready(function() {
                $('.delete-booking-btn').on('click', function() {
                    var bookingId = $(this).closest('tr').find('.booking-id').text();

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You won\'t be able to revert this!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: 'delete_booking.php',
                                data: {
                                    booking_id: bookingId
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Booking has been deleted.',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                },
                                error: function(error) {
                                    console.error('Error deleting booking:', error);
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while deleting the booking.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });
            });
            </script>

            <?php else: ?>
            <p>Tidak ada data pemesanan lapangan.</p>
            <?php endif; ?>
        </div>
    </div>


    <?php } ?>
    <!-- Fungsi-fungsi admin lainnya -->
    <!-- ... (tambahkan fungsi admin sesuai kebutuhan) -->

    <script src="js/script.js"></script> <!-- Sesuaikan dengan lokasi berkas JavaScript Anda -->
</body>

</html>