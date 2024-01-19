<?php
session_start();

// Include database connection
include 'includes/db_connection.php';

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user data from the database
$sql_get_user = "SELECT * FROM users WHERE id = ?";
$stmt_get_user = $conn->prepare($sql_get_user);
$stmt_get_user->bind_param("i", $user_id);
$stmt_get_user->execute();
$result_user = $stmt_get_user->get_result();

// Check if user data is found
if ($result_user->num_rows > 0) {
    $row = $result_user->fetch_assoc();

    // Check if the fetched user ID matches the session user ID
    if ($row['id'] != $user_id) {
        echo "Anda tidak memiliki akses untuk mengedit data user ini.";
        exit();
    }

    // Assign user data to variables
    $nama = $row['nama'];
    $email = $row['email'];
    $telpon = $row['telpon'];
    $foto = $row['foto'];
    $username = $row['username'];
    $password = $row['password'];
} else {
    echo "Data user tidak ditemukan.";
    exit();
}

// Process user data update
// ...

// Process user data update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telpon = $_POST['telpon'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Handle file upload for the foto field
    // Proses upload foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
        if (in_array($_FILES['foto']['type'], $allowed_types)) {
            $file_name = uniqid() . '.' . strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            $target_dir = 'uploads/';
            $target_file = $target_dir . $file_name;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                // Foto berhasil diupload
                $foto = $file_name;
            } else {
                // Foto gagal diupload
                echo "Gagal mengupload foto.";
            }
        } else {
            echo "Tipe file tidak diperbolehkan.";
        }
    }

    // Hash password baru jika tidak kosong
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // Jika password kosong, gunakan password yang sudah ada di database
        $hashed_password = $row['password'];
    }

    // Query untuk update data user
    $sql_update_user = "UPDATE users SET nama = ?, email = ?, telpon = ?, foto = ?, username = ?, password = ? WHERE id = ?";
    $stmt_update_user = $conn->prepare($sql_update_user);
    $stmt_update_user->bind_param("ssssssi", $nama, $email, $telpon, $foto, $username, $hashed_password, $user_id);
    $stmt_update_user->execute();

    // Cek apakah update berhasil
    if ($stmt_update_user->affected_rows > 0) {
        // Update berhasil
        header("Location: profiluser.php?message=Data user berhasil diupdate.");
        exit();
    } else {
        // Update gagal
        echo "Terjadi kesalahan saat mengupdate data user.";
    }
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h1>Edit profil</h1>

    <form action="" method="post" enctype="multipart/form-data">

        <p>
            <label for="nama">Nama:</label>
            <input type="text" name="nama" id="nama" value="<?php echo $nama; ?>" required>
        </p>
        <p>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $email; ?>" required>
        </p>
        <p>
            <label for="telpon">No HP/WA:</label>
            <input type="tel" name="telpon" id="telpon" value="<?php echo $telpon; ?>" required>
        </p>
        <p>
            <label for="foto">Foto</label>
            <input type="file" name="foto" id="foto" accept="image/*">

            <?php if (!empty($foto)) echo "<img src='uploads/" . $foto . "' alt='Foto Pengguna' style='max-width: 100px;'>"; ?>




        </p>
        <p>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php echo $username; ?>" required>
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </p>

        <p>
            <input type="submit" name="submit" value="Simpan">
        </p>

    </form>

    <a href="profiluser.php">Kembali ke Pesanan Saya</a>

</body>

</html>