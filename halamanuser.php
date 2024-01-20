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

include 'includes/db_connection.php'; // Sertakan file koneksi database

// Query untuk mendapatkan informasi lapangan pada tanggal hari ini
// Tambahkan pesan log sebelum dan sesudah eksekusi query
// Ambil tanggal hari ini

// Ambil tanggal hari ini dalam format YYYY-MM-DD
$currentDate = date("Y-m-d");

// Kueri SQL untuk mendapatkan pesanan hari ini
// Check if the form is submitted with a date filter
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filter_tanggal'])) {
    $filterDate = $_POST['filter_tanggal'];

    // Update the SQL query to filter bookings by the selected date
    $sql_get_today_bookings = "SELECT bookingan.*, users.username AS nama_pemesan
                               FROM bookingan
                               INNER JOIN users ON bookingan.user_id = users.id
                               WHERE DATE(bookingan.tanggal) = '$filterDate'";
} else {
    // Use the original query to get today's bookings
    $sql_get_today_bookings = "SELECT bookingan.*, users.username AS nama_pemesan
                               FROM bookingan
                               INNER JOIN users ON bookingan.user_id = users.id
                               WHERE DATE(bookingan.tanggal) = '$currentDate'";
}

$result_today_bookings = $conn->query($sql_get_today_bookings);



?>

<head>
    <style>
    /* Styles for the modal overlay */
    #filter-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    /* Styles for the modal content */
    #filter-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        text-align: center;
    }
    </style>

</head>

<body>
    <?php include 'navbar.php'; ?>


    <!-- Konten dashboard lainnya -->


    <div class="content" style="margin-bottom: 100px;">

        <h3> <?php include 'jam.php'?></h3>

        <h1>Informasi Lapangan</h1>
        <button id="open-filter"
            style="float: right; border: none;  padding: 10px px 10px 0px; font-size: 15px; color:#545454;">Filter
            berdasarkan
            tanggal <i class="bi bi-filter"
                style="font-size: 30px; border: 1px solid grey; border-radius: 5px; padding: 0px 5px 0px 5px"></i></button>

        <!-- Filter Modal -->
        <div id="filter-modal">
            <div id="filter-container">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <button id="close-filter" style="margin-left:100%; background-color: red; "><i
                            class="bi bi-x-square"></i></button>
                    <h2>Filter Pemesanan</h2>
                    <label for="filter-tanggal">Filter Berdasarkan Tanggal:</label>
                    <input type="date" id="filter-tanggal" name="filter_tanggal" required>
                    <button type="submit" id="filter-button">Filter</button>
                </form>
            </div>
        </div>


        <div id="lapangan-info">
            <?php if ($result_today_bookings->num_rows > 0): ?>
            <table border="1" class="table table-hover table-light">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Jenis Lapangan</th>
                        <th>Nama Pemesan</th>

                        <!-- Tambahkan kolom lain jika diperlukan -->
                    </tr>
                </thead>
                <tbody>

                    <?php
                     $no = 1; 
                    while ($row = $result_today_bookings->fetch_assoc()): 
                    ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php
// Fungsi untuk mengubah nama hari dalam bahasa Inggris menjadi bahasa Indonesia
if (!function_exists('hari_indo')) {
  function hari_indo($hari) {
      $nama_hari = array(
          'Sun' => 'Minggu',
          'Mon' => 'Senin',
          'Tue' => 'Selasa',
          'Wed' => 'Rabu',
          'Thu' => 'Kamis',
          'Fri' => 'Jumat',
          'Sat' => 'Sabtu'
      );
      return $nama_hari[$hari];
  }
}

// Misalkan $row['tanggal'] mengandung tanggal dari database
$tanggal = $row['tanggal'];

// Ubah format tanggal menjadi d-m-Y
$tanggal_baru = date_format(date_create($tanggal), 'd-m-Y');

// Ambil nama hari dari tanggal dengan format D
$nama_hari = date('D', strtotime($tanggal));

// Ubah nama hari ke bahasa Indonesia
$nama_hari_indo = hari_indo($nama_hari);

// Tampilkan nama hari dan tanggal baru di dalam tag <>
echo "$nama_hari_indo/$tanggal_baru";

?>
                        </td>
                        <td><?php echo $row['jam_mulai']; ?></td>
                        <td><?php echo $row['jam_selesai']; ?></td>
                        <td><?php echo $row['jenis_lapangan']; ?></td>
                        <td><?php echo $row['nama_pemesan']; ?></td>

                        <!-- Tambahkan baris data lain sesuai dengan kolom yang Anda miliki -->
                    </tr>
                    <?php 
                    $no++;
                endwhile;
                
                ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>Tidak ada data pemesanan lapangan.</p>
            <?php endif; ?>
        </div>

        <h2>Pesan Lapangan</h2>
        <?php if (isset($_SESSION['username'])): ?>
        <form action="process_booking.php" method="post">
            <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
            <label for="tanggal">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" required><br><br>

            <label for="jam-mulai">Jam Mulai:</label>
            <input type="time" id="jam-mulai" name="jam_mulai" required><br><br>

            <label for="jam-selesai">Jam Selesai:</label>
            <input type="time" id="jam-selesai" name="jam_selesai" required><br><br>



            <button type="submit">Pesan Lapangan</button>
        </form>
        <?php else: ?>
        <p>Silakan login untuk melakukan pemesanan.</p>
        <?php endif; ?>
    </div>

    <script src="js/sweetalert2-11.10.1/package/dist/sweetalert2.min.js"></script> <!-- Ganti dengan path yang benar -->
    <script>
    <?php 
    if(isset($_SESSION['pesan_alert'])): ?>
    <?php
            // Tentukan icon berdasarkan status pesanan
            $icon = ($_SESSION['status_pemesanan'] === 'berhasil') ? 'success' : 'error';
        ?>
    // Tampilkan pesan alert menggunakan SweetAlert dengan icon yang ditentukan
    Swal.fire({
        icon: '<?php echo $icon; ?>',
        title: 'Informasi',
        text: '<?php echo $_SESSION['pesan_alert']; ?>'
    });
    <?php unset($_SESSION['pesan_alert']); ?>
    <?php unset($_SESSION['status_pemesanan']); ?>
    <?php endif; ?>
    </script>
    <script>
    // JavaScript to show and hide the modal
    document.getElementById("open-filter").addEventListener("click", function() {
        document.getElementById("filter-modal").style.display = "flex";
    });

    document.getElementById("close-filter").addEventListener("click", function() {
        document.getElementById("filter-modal").style.display = "none";
    });
    </script>


    <script src="js/script.js"></script>
    <!-- Sesuaikan dengan lokasi berkas JavaScript Anda -->
</body>

</html>