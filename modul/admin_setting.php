<?php
include 'includes/db_connection.php';  // Sertakan file koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $harga_per_jam = $_POST['harga_per_jam'];
    $lapangan_id = $_POST['nama_lapangan']; // Ambil nilai lapangan_id dari formulir

    // Query untuk menyimpan harga per jam ke dalam database
    $sql_update_harga = "UPDATE lapangan SET harga_per_jam = ? WHERE nama_lapangan = ?";
    $stmt_update_harga = $conn->prepare($sql_update_harga);
    $stmt_update_harga->bind_param("is", $harga_per_jam, $lapangan_id);


    $stmt_update_harga->execute();
    $stmt_update_harga->close();

    header("Location: halamanadmin.php?modul=admin_setting"); // Redirect kembali ke halaman admin setting
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Setting</title>
    <link rel="stylesheet" href="../css/style.css">

    <style>
    #adminSettingContainer {
        width: 50%;
        margin: auto;

    }
    </style>
</head>

<body>

    <div id="adminSettingContainer">
        <h1>Admin Setting</h1>
        <br>
        <h3>Edit harga</h3>
        <form action="halamanadmin.php?modul=admin_setting" method="post">
            <label for="harga_per_jam">Harga per Jam:</label>
            <input type="number" id="harga_per_jam" name="harga_per_jam" required><br><br>


            <label for="nama_lapangan">Pilih Lapangan:</label>
            <select id="nama_lapangan" name="nama_lapangan" required>
                <option value="siang">Siang</option>
                <option value="malam">Malam</option>
                <!-- Tambahkan opsi lain sesuai kebutuhan -->
            </select>



            <button type="submit" style="width: 100%;">Simpan</button>
        </form>
    </div>
</body>

</html>