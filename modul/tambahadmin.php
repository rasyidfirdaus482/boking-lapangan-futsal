<?php
// Memulai sesi jika belum ada sesi yang aktif
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifikasi sesi
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect jika bukan admin
    exit();
}

// Menyertakan file conn

// include '../includes/db_connection.php';


// Fungsi untuk menambahkan admin ke dalam tabel user
function tambahAdmin($nama, $email, $telpon, $username, $password, $role) {
    global $conn;

    // Melakukan sanitasi input untuk mencegah SQL injection
    $nama = mysqli_real_escape_string($conn, $nama);
    $email = mysqli_real_escape_string($conn, $email);
    $telpon = mysqli_real_escape_string($conn, $telpon);
    $username = mysqli_real_escape_string($conn, $username);

    // Hash password sebelum menyimpannya
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Query SQL untuk menambahkan admin ke dalam tabel user
    $query = "INSERT INTO users (nama, email, telpon, username, password, role) VALUES ('$nama', '$email', '$telpon', '$username', '$hashedPassword', '$role')";

    if ($conn->query($query) === TRUE) {
        $_SESSION['pesan_alert'] = "Admin berhasil ditambahkan!";
        $_SESSION['status_alert'] = 'success';
        
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Memeriksa apakah formulir telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil nilai dari formulir
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $telpon = $_POST["telpon"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = "admin"; // Atau sesuaikan dengan cara penentuan role admin pada sistem Anda.

    // Menampilkan nilai variabel untuk debugging
    // echo "Nama: $nama<br>";
    // echo "Email: $email<br>";
    // echo "Telepon: $telpon<br>";
    // echo "Username: $username<br>";
    // // Password tidak ditampilkan untuk alasan keamanan
    // // echo "Password: $password<br>";
    // echo "Role: $role<br>";

    // Memanggil fungsi untuk menambahkan admin
    tambahAdmin($nama, $email, $telpon, $username, $password, $role);
}

// Menutup conn ke database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>
<body>

<h2>Form Tambah Admin</h2>
<?php
if (isset($_SESSION['pesan_alert']) && $_SESSION['status_alert'] === 'success') {
    echo '<script>
            Swal.fire({
                icon: "success",
                title: "Sukses!",
                text: "' . $_SESSION['pesan_alert'] . '",
            });
          </script>';

    // Hapus session setelah menampilkannya
    unset($_SESSION['pesan_alert']);
    unset($_SESSION['status_alert']);
} ?>
<form method="post" action="halamanadmin.php?modul=tambahadmin">
    <label for="nama">Nama:</label>
    <input type="text" id="nama" name="nama" required><br>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" required><br>

    <label for="telpon">Telepon:</label>
    <input type="text" id="telpon" name="telpon" required><br>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <input type="submit" value="Tambah Admin">
</form>

</body>
</html>
