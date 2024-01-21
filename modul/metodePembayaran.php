<?php
include 'includes/db_connection.php';

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


// Fungsi pembuat token CSRF
function generateCSRFToken()
{
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
    return $token;
}

// Fungsi pengecekan token CSRF
function verifyCSRFToken($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Validasi formulir
$metode_pembayaran = isset($_POST['metode_pembayaran']) ? $_POST['metode_pembayaran'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $csrf_token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';

    if (!verifyCSRFToken($csrf_token)) {
        // Token CSRF tidak valid, mungkin serangan CSRF
        die("Token CSRF tidak valid");
    }

    // Inisialisasi $stmt dengan nilai default null
    $stmt = null;

    if ($metode_pembayaran == 'transfer_bank') {
        $nama_bank = isset($_POST['nama_bank']) ? $_POST['nama_bank'] : '';
        $nomor_rekening = isset($_POST['nomor_rekening']) ? $_POST['nomor_rekening'] : '';
        $nama_rekening = isset($_POST['nama_rekening']) ? $_POST['nama_rekening'] : '';
    
        // Validasi data transfer_bank
        if (empty($nama_bank) || empty($nomor_rekening) || empty($nama_rekening)) {
            die("Harap isi semua field untuk metode Transfer Bank.");
        }
    
        // Gunakan Prepared Statements
        $query = "INSERT INTO metode_pembayaran (metode, nama_bank, nomor_rekening, nama_rekening) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $metode_pembayaran, $nama_bank, $nomor_rekening, $nama_rekening);
    
    } elseif ($metode_pembayaran == 'dana') {
        $nama_dana = isset($_POST['nama_dana']) ? $_POST['nama_dana'] : '';
        $qr_code_path = ''; // Inisialisasi variabel
    
        // Validasi data dana
        if (empty($nama_dana)) {
            die("Harap isi semua field untuk metode DANA.");
        }
    
        // Upload file QR Code jika ada
        if (!empty($_FILES["qr_code"]["name"])) {
            $qr_code_path = "uploads/qr_code_" . time() . "_" . basename($_FILES["qr_code"]["name"]);
            if (!move_uploaded_file($_FILES["qr_code"]["tmp_name"], $qr_code_path)) {
                die("Error uploading QR Code. Silakan coba lagi.");
            }
        } else {
            die("Harap pilih file QR Code.");
        }
    
        // Simpan data ke database
        $query = "INSERT INTO metode_pembayaran (metode, nama_dana, qr_code_path) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $metode_pembayaran, $nama_dana, $qr_code_path);
    } elseif ($metode_pembayaran == 'cod') {
        // Kode untuk metode pembayaran "COD"
        // Simpan data ke database
        $query = "INSERT INTO metode_pembayaran (metode) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $metode_pembayaran);
    }

    // Eksekusi statement
    if ($stmt !== null && $stmt->execute()) {
        // Data berhasil disimpan, hapus token CSRF
        unset($_SESSION['csrf_token']);

        // Redirect menggunakan JavaScript
        echo '<script>window.location.href = "halamanadmin.php?modul=metodePembayaran";</script>';
        exit(); // tambahkan exit() setelah redirect
    } else {
        // Handle error dengan graceful
        echo "Error: Terjadi kesalahan dalam menyimpan data. Silakan coba lagi.";
    }

    // Tutup statement
    if ($stmt !== null) {
        $stmt->close();
    }
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Tag head lainnya -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Metode Pembayaran</title>
    <script>
    function toggleForm() {
        var metodePembayaran = document.getElementById("metode_pembayaran").value;
        var transferBankForm = document.getElementById("transfer_bank_form");
        var danaForm = document.getElementById("dana_form");

        // Reset validasi untuk semua input
        document.getElementById("nama_bank").removeAttribute("required");
        document.getElementById("nomor_rekening").removeAttribute("required");
        document.getElementById("nama_rekening").removeAttribute("required");
        document.getElementById("nama_dana").removeAttribute("required");
        document.getElementById("qr_code").removeAttribute("required");

        // Sesuaikan validasi berdasarkan metode pembayaran
        if (metodePembayaran === "transfer_bank") {
            transferBankForm.style.display = "block";
            document.getElementById("nama_bank").setAttribute("required", "true");
            document.getElementById("nomor_rekening").setAttribute("required", "true");
            document.getElementById("nama_rekening").setAttribute("required", "true");

            // Menonaktifkan validasi untuk input dana
            document.getElementById("nama_dana").removeAttribute("required");
            document.getElementById("qr_code").removeAttribute("required");

            danaForm.style.display = "none";
        } else if (metodePembayaran === "dana") {
            danaForm.style.display = "block";
            document.getElementById("nama_dana").setAttribute("required", "true");
            document.getElementById("qr_code").setAttribute("required", "true");

            // Menonaktifkan validasi untuk input transfer_bank
            document.getElementById("nama_bank").removeAttribute("required");
            document.getElementById("nomor_rekening").removeAttribute("required");
            document.getElementById("nama_rekening").removeAttribute("required");

            transferBankForm.style.display = "none";
        } else {
            // COD tidak memerlukan data tambahan
            transferBankForm.style.display = "none";
            danaForm.style.display = "none";
        }
    }
    </script>
</head>

<body>
    <!-- Formulir menggunakan token CSRF -->
    <form action="halamanadmin.php?modul=metodePembayaran" method="post" enctype="multipart/form-data">
        <!-- Tambahkan input hidden untuk menyimpan token CSRF -->
        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

        <label for="metode_pembayaran">Metode Pembayaran:</label>
        <select name="metode_pembayaran" id="metode_pembayaran" onchange="toggleForm()">
            <option value="transfer_bank">Transfer Bank</option>
            <option value="dana">DANA</option>
            <option value="cod">COD</option>
        </select>

        <!-- Transfer Bank Form dan DANA Form tetap sama -->
        <!-- Transfer Bank Form -->
        <div id="transfer_bank_form">
            <label for="nama_bank">Nama Bank:</label>
            <input type="text" name="nama_bank" id="nama_bank">

            <br>

            <label for="nomor_rekening">Nomor Rekening:</label>
            <input type="text" name="nomor_rekening" id="nomor_rekening">

            <br>

            <label for="nama_rekening">Nama Rekening:</label>
            <input type="text" name="nama_rekening" id="nama_rekening">

            <br>
        </div>

        <!-- DANA Form -->
        <div id="dana_form" style="display: none;">
            <label for="nama_dana">Nama DANA:</label>
            <input type="text" name="nama_dana" id="nama_dana">

            <br>

            <label for="qr_code">Gambar QR Code:</label>
            <input type="file" name="qr_code" id="qr_code" accept="image/*">

            <br>
        </div>

        <button type="submit">Submit</button>
    </form>
</body>

</html>