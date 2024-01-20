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

// Query untuk mendapatkan harga per jam lapangan siang
$sql_get_harga_per_jam_siang = "SELECT harga_per_jam FROM lapangan WHERE nama_lapangan = 'siang'";
$stmt_get_harga_per_jam_siang = $conn->prepare($sql_get_harga_per_jam_siang);
$stmt_get_harga_per_jam_siang->execute();
$result_harga_per_jam_siang = $stmt_get_harga_per_jam_siang->get_result();

// Ambil harga per jam lapangan siang
if ($result_harga_per_jam_siang->num_rows == 1) {
    $row_harga_per_jam_siang = $result_harga_per_jam_siang->fetch_assoc();
    $harga_per_jam_siang = $row_harga_per_jam_siang['harga_per_jam']; // Ambil nilai harga per jam dari database
} else {
    // Tindakan jika harga per jam tidak ditemukan
    $harga_per_jam_siang = 0; // Atur nilai default jika tidak ditemukan
}
$stmt_get_harga_per_jam_siang->close();

// Query untuk mendapatkan harga per jam lapangan malam
$sql_get_harga_per_jam_malam = "SELECT harga_per_jam FROM lapangan WHERE nama_lapangan = 'malam'";
$stmt_get_harga_per_jam_malam = $conn->prepare($sql_get_harga_per_jam_malam);
$stmt_get_harga_per_jam_malam->execute();
$result_harga_per_jam_malam = $stmt_get_harga_per_jam_malam->get_result();

// Ambil harga per jam lapangan malam
if ($result_harga_per_jam_malam->num_rows == 1) {
    $row_harga_per_jam_malam = $result_harga_per_jam_malam->fetch_assoc();
    $harga_per_jam_malam = $row_harga_per_jam_malam['harga_per_jam']; // Ambil nilai harga per jam dari database
} else {
    // Tindakan jika harga per jam tidak ditemukan
    $harga_per_jam_malam = 0; // Atur nilai default jika tidak ditemukan
}
$stmt_get_harga_per_jam_malam->close();

$now = date("Y-m-d H:i:s");
// Query untuk mendapatkan pesanan pengguna
$sql_get_user_bookings = "SELECT * FROM bookingan WHERE user_id = ?";
$stmt_get_user_bookings = $conn->prepare($sql_get_user_bookings);
$stmt_get_user_bookings->bind_param("i", $user_id);
$stmt_get_user_bookings->execute();
$result_user_bookings = $stmt_get_user_bookings->get_result();

if ($result_user_bookings === false) {
    echo "Terjadi kesalahan saat mengambil data pemesanan.";
    // Tambahkan penanganan kesalahan sesuai kebutuhan aplikasi Anda
}
$sql_get_user = "SELECT * FROM users WHERE id = ?";
$stmt_get_user = $conn->prepare($sql_get_user);
$stmt_get_user->bind_param("i", $user_id);
$stmt_get_user->execute();
$result_user = $stmt_get_user->get_result();

if ($result_user === false) {
    echo "Terjadi kesalahan saat mengambil data pemesanan.";
    // Tambahkan penanganan kesalahan sesuai kebutuhan aplikasi Anda
} else {
    // Ambil data dan simpan dalam variabel atau array
    $user_data = $result_user->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>

    <!-- Custom Css -->
    <link rel="stylesheet" href="css/profil.css">


    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <style>
    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button a {
        color: white;
        text-decoration: none;
    }

    button:hover {
        background-color: #7af46c;
    }

    table td {
        border: none !important;
        text-align: left !important;
    }
    </style>
</head>

<body>
    <!-- Navbar top -->
    <?php include 'navbarprofil.php'; ?>

    <!-- End -->

    <!-- Sidenav -->
    <div class="sidenav">
        <div class="profile">
            <img src="uploads/<?php echo $user_data['foto']; ?>" alt="Foto Pengguna" width="100" height="100">
            <div class="name">
                <?php echo $user_data['username']; ?>
            </div>
            <div class="job">
                Pemain
            </div>
        </div>

        <div class="sidenav-url">
            <div class="url">
                <a href="#profile" class="active">Profile</a>
                <hr align="center">
            </div>
            <div class="url">
                <a href="#settings">Settings</a>
                <hr align="center">
            </div>
        </div>
    </div>
    <!-- End -->
    <div></div>
    <!-- Main -->
    <div class="main" style="margin-top: 6%;">
        <h2>IDENTITY</h2>
        <div class="card">
            <div class="card-body">
                <a href="edit_profil.php"><i class="fa fa-pen fa-xs edit" style="color: Black"></i></a>

                <table style="height: fit-content;">
                    <tbody>
                        <tr>

                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td><?php echo $user_data['nama']; ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td><?php echo $user_data['email']; ?></td>
                        </tr>
                        <tr>
                            <td>telepon</td>
                            <td>:</td>
                            <td><?php echo $user_data['telpon']; ?></td>
                        </tr>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <h2>PESANAN</h2>
        <div class="card">


            <?php if ($result_user_bookings->num_rows > 0): ?>
            <table>
                <!-- Tampilkan header tabel -->
                <thead>
                    <tr>
                        <th align="left">Pesanan</th>

                        <!-- Kolom untuk tombol aksi -->
                    </tr>
                    <tr>
                        <td align="center" style="color:crimson;">Pesanan yang sudah dibayar tidak bisa di edit!!</td>

                        <!-- Kolom untuk tombol aksi -->
                    </tr>

                </thead>
                <tbody>
                    <?php while ($row = $result_user_bookings->fetch_assoc()): ?>

                    <tr>

                        <td>
                    <tr>
                        <!-- Tampilkan data pesanan -->
                        <td><label>tanggal</label></td>
                        <td>:</td>
                        <td><?php echo $row['tanggal']; ?></td>
                    </tr>
                    <tr>
                        <td><label>jam mulai </label></td>
                        <td>:</td>
                        <td><?php echo $row['jam_mulai']; ?></td>
                    </tr>
                    <tr>
                        <td><label>jam selesai </label></td>
                        <td>:</td>
                        <td><?php echo $row['jam_selesai']; ?></td>
                    </tr>
                    <tr>
                        <td><label>jenis lapangan </label></td>
                        <td>:</td>
                        <td><?php echo $row['jenis_lapangan']; ?></td>
                    </tr>
                    <tr>
                        <td><label>Harga </label></td>
                        <td>:</td>
                        <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>


                    </tr>
                    </td>
                    <tr>
                        <td>
                            <label>Status </label>
                        <td>:</td>
                        </td>
                        <td>
                            <?php echo $row['status']; ?><br></td>
                    </tr>

                    <tr>
                        <td>
                            <label>Status bayar</label>
                        <td>:</td>
                        </td>
                        <td>
                            <?php echo $row['status_bayar']; ?><br></td>
                    </tr>
                    <!-- Tambahkan kolom untuk tombol aksi -->
                    <tr>
                        <td>
                            <button style="background-color: red;"
                                onclick="showCancelAlert(<?php echo $row['id']; ?>)">Batalkan</button>
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                            function showCancelAlert(id) {
                                Swal.fire({
                                    title: "Kamu yakin?",
                                    text: "Uang yang telah dibayar tidak bisa kembali!",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonColor: "#d33",
                                    confirmButtonText: "Yakin, hapus saja!"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Redirect to the cancel_booking.php with the provided id
                                        window.location.href = "cancel_booking.php?id=" + id;
                                    }
                                });
                            }
                            </script>

                            <?php
                // Check if the payment status is "Belum Dibayar"
                if ($row['status_bayar'] == 'Dibayar') {
                    // Show the "Edit" button
                    echo '<button disabled>Edit</button>';
                    
                } else {
                    // Disable the "Edit" button if the payment is "Dibayar"
                    echo '<button><a href="edit_boking.php?id=' . $row['id'] . '">Edit</a></button>';
                }
                ?>
                        </td>
                    </tr>

                    </td>
                    </tr>

                    <?php endwhile; ?>

                </tbody>
            </table>
            <button style="margin-left: 13px; width:90%; background-color: orangered; font-size: 20px;"><a
                    href="pembayaran.php">bayar</a></button>
            <?php else: ?>
            <p>Anda belum melakukan pemesanan.</p>
            <?php endif; ?>

        </div>
        <!-- End -->


        <script src="js/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>