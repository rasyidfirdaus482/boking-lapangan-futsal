<?php
require 'vendor/autoload.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'includes/db_connection.php';

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Ambil detail pemesanan berdasarkan $booking_id
    $sql_get_booking_details = "SELECT * FROM bookingan WHERE id = ?";
    $stmt_get_booking_details = $conn->prepare($sql_get_booking_details);
    $stmt_get_booking_details->bind_param("i", $booking_id);
    $stmt_get_booking_details->execute();
    $result_booking_details = $stmt_get_booking_details->get_result();

    if ($result_booking_details->num_rows == 1) {
        $row_booking_details = $result_booking_details->fetch_assoc();
    
        // Gunakan $row_booking_details untuk mendapatkan detail pemesanan
        $id = $row_booking_details['id'];
        $tanggal = $row_booking_details['tanggal'];
        $jam_mulai = $row_booking_details['jam_mulai'];
        $jam_selesai = $row_booking_details['jam_selesai'];
        $jenis_lapangan = $row_booking_details['jenis_lapangan'];
        $total_harga = $row_booking_details['total_harga'];
        
        // Perhatikan kolom yang digunakan untuk mendapatkan ID lapangan
        $lapangan_id = $row_booking_details['id']; // Sesuaikan dengan kolom yang sesuai
    
       
        

   
// Buat objek TCPDF
$pdf = new TCPDF();

// Atur ukuran halaman menjadi setengah dari A4
$pdf->AddPage('P', array(105, 175)); // Ukuran dalam milimeter

// Atur agar halaman tidak pecah jika content terlalu panjang
$pdf->SetAutoPageBreak(true, 0);


// Hasilkan konten PDF
ob_start();
include 'invoice_template.php'; // File template HTML untuk invoice
$html = ob_get_clean();
$pdf->writeHTML($html, true, false, true, false, '');

// Keluarkan file PDF
$pdf->Output('invoice.pdf', 'I');
exit();
    } else {
        // Tanggapi jika pemesanan tidak ditemukan
        echo "Pemesanan tidak ditemukan.";
    }

    $stmt_get_booking_details->close();
} else {
    // Tangani kasus ketika tidak ada ID pemesanan yang diberikan
    echo "ID Pemesanan tidak valid.";
}
?>