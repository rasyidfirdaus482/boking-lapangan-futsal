<?php

include 'includes/db_connection.php';

// ... (koneksi ke database dan validasi sesi)

$sql_get_users = "SELECT * FROM users WHERE role = 'admin'";
$result_users = $conn->query($sql_get_users);

if ($result_users === false) {
    echo "Terjadi kesalahan saat mengambil data pengguna.";
    // Tambahkan penanganan kesalahan sesuai kebutuhan aplikasi Anda
} else {
    $users_data = $result_users->fetch_all(MYSQLI_ASSOC);
}

// Tambahkan kode untuk menghapus user:
// Tambahkan kode untuk menghapus user:
if (isset($_POST['id_user']) && !empty($_POST['id_user'])) {
    $id_user = $_POST['id_user'];

    // Sanitize the ID to prevent SQL injection attacks
    $id_user = mysqli_real_escape_string($conn, $id_user);

    $sql_delete_user = "DELETE FROM users WHERE id = $id_user";
    if ($conn->query($sql_delete_user) === true) {
        // Set pesan sukses dalam session
        $_SESSION['pesan_alert'] = "User berhasil dihapus!";
        $_SESSION['status_alert'] = 'success';

        // Redirect ke halaman admin
        header("Location: halamanadmin.php?modul=dataadmin");
        exit();
    } else {
        // Set pesan kesalahan dalam session
        $_SESSION['pesan_alert'] = "Terjadi kesalahan saat menghapus data pengguna.";
        $_SESSION['status_alert'] = 'error';
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Users</title>
    <!-- Tambahkan library Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body>
    <div class="tabel" style="width: 80%; margin: auto;">
        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah admin"
            style="border-radius: 15%; height: 40px; width: 60px; background-color:#0000CD; margin: 10px;"> <a
                href="halamanadmin.php?modul=tambahadmin"><i class="bi bi-person-plus-fill"
                    style="color: white;"></i></a></button>
        <table class="table table-hover table-light" style="height: fit-content;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>username</th>
                    <th>role</th>
                    <th>aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users_data)) {
                 $no = 1;
                foreach ($users_data as $user_data) { ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $user_data['nama']; ?></td>
                    <td><?php echo $user_data['email']; ?></td>
                    <td><?php echo $user_data['telpon']; ?></td>
                    <td><?php echo $user_data['username']; ?></td>
                    <td><?php echo $user_data['role']; ?></td>
                    <td>

                        <form action="halamanadmin.php?modul=dataadmin" method="post"
                            id="hapusUserForm_<?php echo $user_data['id']; ?>">
                            <input type="hidden" name="id_user" value="<?php echo $user_data['id']; ?>">
                            <button class="bi bi-trash" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Hapus Admin" type="submit" value="Hapus"
                                onclick="return confirmHapusUser(event, <?php echo $user_data['id']; ?>)">
                        </form>

                    </td>
                </tr>


                <?php $no++; }
            } else { ?>
                <tr>
                    <td colspan="3">Data users tidak ditemukan.</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <script>
        // Cek apakah ada pesan alert dalam session
        <?php if (isset($_SESSION['pesan_alert']) && isset($_SESSION['status_alert'])): ?>
        Swal.fire({
            title: '<?php echo ($_SESSION['status_alert'] === 'success') ? "Berhasil!" : "Error!"; ?>',
            text: '<?php echo $_SESSION['pesan_alert']; ?>',
            icon: '<?php echo ($_SESSION['status_alert'] === 'success') ? "success" : "error"; ?>'
        });
        <?php
        // Hapus pesan alert dari session setelah ditampilkan
        unset($_SESSION['pesan_alert']);
        unset($_SESSION['status_alert']);
    endif;
    ?>
        </script>
        <script>
        async function confirmHapusUser(event, idUser) {
            event.preventDefault(); // Mencegah formulir di-submit secara otomatis

            const result = await Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Yakin ingin menghapus user ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            });

            if (result.isConfirmed) {
                // Hapus pengguna hanya jika pengguna mengklik "Ya"
                document.getElementById('hapusUserForm_' + idUser).submit();
            }

            // Mengembalikan false agar formulir tidak di-submit secara otomatis
            return false;
        }
        </script>



        <script src="js/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>

</html>