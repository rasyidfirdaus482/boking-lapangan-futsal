<?php
include 'includes/db_connection.php';

// ... (koneksi ke database dan validasi sesi)

$sql_get_users = "SELECT * FROM users WHERE role = 'user'";
$result_users = $conn->query($sql_get_users);

if ($result_users === false) {
    echo "Terjadi kesalahan saat mengambil data pengguna.";
    // Tambahkan penanganan kesalahan sesuai kebutuhan aplikasi Anda
} else {
    $users_data = $result_users->fetch_all(MYSQLI_ASSOC);
}

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
        header("Location: halamanadmin.php?modul=datauser");
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
        <table style="height: fit-content;" class="table table-hover table-light">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>username</th>
                    <th>role</th>
                    <th>Aksi</th> <!-- Kolom untuk tombol aksi -->
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users_data)) {
                foreach ($users_data as $user_data) { ?>
                <tr>
                    <td><?php echo $user_data['nama']; ?></td>
                    <td><?php echo $user_data['email']; ?></td>
                    <td><?php echo $user_data['telpon']; ?></td>
                    <td><?php echo $user_data['username']; ?></td>
                    <td><?php echo $user_data['role']; ?></td>
                    <td>
                        <!-- Tombol "Hapus" dengan Sweet Alert -->
                        <button class="bi bi-trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Admin"
                            onclick="confirmHapusUser(<?php echo $user_data['id']; ?>)">Hapus</button>
                        <!-- Form untuk penghapusan -->
                        <form action="halamanadmin.php?modul=datauser" method="post"
                            id="hapusUserForm_<?php echo $user_data['id']; ?>">
                            <input type="hidden" name="id_user" value="<?php echo $user_data['id']; ?>">
                        </form>
                    </td>
                </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="6">Data users tidak ditemukan.</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <script src="js/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

        <script>
        async function confirmHapusUser(idUser) {
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
        }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>

</html>