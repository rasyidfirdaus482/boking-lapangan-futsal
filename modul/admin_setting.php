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
        <form action="../process_admin_setting.php" method="post">
            <label for="harga_per_jam">Harga per Jam:</label>
            <input type="number" id="harga_per_jam" name="harga_per_jam" required><br><br>

            <label for="nama_lapangan">Pilih Lapangan:</label>
            <select id="nama_lapangan" name="nama_lapangan" required>
                <option value="lapangan1">Siang</option>
                <option value="lapangan2">Malam</option>
                <!-- Tambahkan opsi lain sesuai kebutuhan -->
            </select>



            <button type="submit" style="width: 100%;">Simpan</button>
        </form>
    </div>
</body>

</html>