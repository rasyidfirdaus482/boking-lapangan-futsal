<?php
// Menggunakan koneksi ke database yang sudah dibuat sebelumnya
include 'includes/db_connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telpon = $_POST['telpon'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role    = 'user'; // Set default role

    // Periksa apakah username sudah digunakan
    $sql_check_username = "SELECT * FROM users WHERE username = ?";
    $stmt_check_username = $conn->prepare($sql_check_username);
    $stmt_check_username->bind_param("s", $username);
    $stmt_check_username->execute();
    $result_check_username = $stmt_check_username->get_result();

    if ($result_check_username->num_rows > 0) {
        $error = "Username sudah digunakan, silakan coba dengan username lain.";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        // Query untuk menambahkan pengguna baru ke tabel users
        $sql_insert_user = "INSERT INTO users (nama, email, telpon, username, password, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert_user = $conn->prepare($sql_insert_user);
        $stmt_insert_user->bind_param("ssssss", $nama, $email, $telpon, $username, $hashed_password, $role);
    
        // Validasi email dan nomor telepon jika diperlukan
        // ...
    
        // Jalankan query
        if ($stmt_insert_user->execute()) {
            $success_message = "Pendaftaran berhasil! Silakan login.";
        } else {
            $error = "Terjadi kesalahan saat mendaftar pengguna.";
        }
    }
    
}

// Tutup koneksi ke basis data
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registrasi Pengguna</title>
    <!-- Masukkan CSS atau styling jika diperlukan -->
    <link rel="stylesheet" href="css/register.css">
</head>

<body>
    <div class="register">
        <h2>Registrasi Pengguna</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table border="0">

                <tr>
                    <td><label for="nama">Nama:</label></td>
                    <td><input type="text" id="nama" name="nama" required></td>
                </tr>

                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" id="email" name="email" required></td>
                </tr>

                <tr>
                    <td><label for="telpon">No Hp/wa:</label></td>
                    <td><input type="tel" id="telpon" name="telpon" required></td>
                </tr>

                <tr>
                    <td><label for="username">Username:</label></td>
                    <td><input type="text" id="username" name="username" required></td>
                <tr>

                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="password" id="password" name="password" required></td>
                </tr>






            </table>
            <p>sudah punya akun? <a href="login.php" style="font-weight: bold;">login</a></p>
            <button type="submit">Daftar</button>
        </form>
    </div>

    <?php
    if (isset($error)) {
        echo "<p>$error</p>";
    } elseif (isset($success_message)) {
        echo "<p>$success_message</p>";
        header("Location: login.php");
        exit();
        
    }
    ?>
</body>

</html>