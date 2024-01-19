<?php
// Sesuaikan sesuai kebutuhan validasi dan tindakan upload bukti pembayaran

session_start();

$response = ['status' => 'error', 'message' => 'Upload bukti gagal.'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id'])) {
    include 'includes/db_connection.php'; // Sesuaikan path dengan kebutuhan

    $booking_id = $_POST['booking_id'];

    // Handle upload bukti pembayaran
    $target_dir = "uploads/bukti_pembayaran/";
    $target_file = $target_dir . basename($_FILES["bukti_pembayaran"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi apakah file gambar
    $check = getimagesize($_FILES["bukti_pembayaran"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $response['message'] = "File bukan gambar.";
        echo json_encode($response);
        exit();
    }

    // Validasi ukuran file (contoh: maksimal 5 MB)
    if ($_FILES["bukti_pembayaran"]["size"] > 5000000) {
        $response['message'] = "Maaf, ukuran file terlalu besar.";
        echo json_encode($response);
        exit();
    }

    // Pindahkan file ke direktori yang diinginkan
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
            // Update kolom bukti_pembayaran pada tabel bookingan
            $sql_update_bukti = "UPDATE bookingan SET bukti_pembayaran = ? WHERE id = ?";
            $stmt_update_bukti = $conn->prepare($sql_update_bukti);
            $stmt_update_bukti->bind_param("si", $target_file, $booking_id);

            if ($stmt_update_bukti->execute()) {
                $response['status'] = 'success';
                $response['message'] = "Bukti pembayaran berhasil diupload.";
            } else {
                $response['message'] = "Gagal mengupdate bukti pembayaran.";
            }

            $stmt_update_bukti->close();
        } else {
            $response['message'] = "Gagal mengupload file.";
        }
    }
} else {
    // Tindakan jika tidak ada data yang diterima
    $response['message'] = "Tidak ada data yang diterima.";
}

echo json_encode($response);
?>
