<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Masukkan CSS atau styling jika diperlukan -->
    <link rel="stylesheet" href="css/login.css">
    <!-- font google roboto-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,700;1,100&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login" id="login">
    <h2>Login</h2>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <p>Belum mempunyai akun?<a href="register.php">Daftar</a></p>
        <br><br>
        <button type="submit">Login</button>
       
    </form>
    </div>

    <?php
    if (isset($error)) {
        echo "<p>$error</p>";
    }
    ?>
</body>
</html>

<?php
session_start();

// Menggunakan koneksi ke database yang sudah dibuat sebelumnya
include 'includes/db_connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa keberadaan pengguna
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Memeriksa password dengan password_verify
        if (password_verify($password, $row['password'])) {
            // Password benar, lakukan proses login
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];
            $_SESSION['user_id'] = $row['id']; // Atur nilai 'user_id' sesuai ID pengguna

            // Memeriksa apakah role dari user adalah admin
            if ($_SESSION['role'] === 'admin') {
                header("Location: halamanadmin.php"); // Jika role adalah admin, alihkan ke halamanadmin.php
                exit();
            } else {
                header("Location: halamanuser.php"); // Ganti dengan halaman pengguna
                exit();
            }
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username atau password salah.";
    }
}



// Tutup koneksi ke basis data
$conn->close();
