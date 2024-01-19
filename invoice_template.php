<!-- invoice_template.php -->
<html>

<head>
    <title>Invoice Pemesanan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 10px;
        border: solid 1px;
    }

    h2 {
        color: #333;
        /* border-bottom: 1px solid #333; */
        padding-bottom: 10px;
        font-family: 'Roboto Mono', monospace;
        text-align: center;
    }

    h3 {
        color: #333;
        border-bottom: 1px solid #333;
        padding-bottom: 10px;
        font-family: 'Roboto Mono', monospace;
        text-align: center;
        margin-top: -10px;
    }

    h5 {
        color: #333;
        border-bottom: 1px solid #333;
        padding-bottom: 10px;
        font-family: 'Roboto Mono', monospace;
        text-align: center;
        margin-top: -10px;
    }

    .invoice-details {
        margin-top: 10px;
        margin-left: 30px;
        margin-right: 20px;
        padding: 10px;
        border-radius: 30px;
        font-family: 'Roboto Mono', monospace;

    }

    .invoice-details p {
        margin: 0;
        margin-bottom: 10px;
        font-size: 10px;
        text-align: start;
    }



    .total-section {
        margin-top: 10px;
        margin-left: 20px;
        margin-right: 20px;
        padding: 10px;
        border-radius: 40px;
        font-family: 'Roboto Mono', monospace;
    }

    .total-section p {
        font-family: 'Roboto Mono', monospace;
        text-align: center;

    }



    .total-amount {
        font-size: 20px;
        font-weight: bold;
        color: #333;
        text-align: center;
        font-family: 'Roboto Mono', monospace;
    }
    </style>
</head>

<body>
    <h2>Invoice Pemesanan</h2>
    <h5>GoFutsal, Jl.salam olahraga No.13</h5>
    <div class="invoice-details">
        <p>Id pesanan: <?php echo $id; ?></p>
        <p>Tanggal: <?php echo $tanggal; ?></p>
        <p>Jam Mulai: <?php echo $jam_mulai; ?></p>
        <p>Jam Selesai: <?php echo $jam_selesai; ?></p>
        <p>Jenis Lapangan: <?php echo $jenis_lapangan; ?></p>
        <!-- ... (tambahkan detail lainnya sesuai kebutuhan) -->
    </div>
    <h3>Total Harga:</h3>
    <div class="total-section">
        <p class="total-amount">Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></p>
        <p style="font-size: 10px;">Simpan struk ini, jika pesanan tak sengaja terbatalkan
            dan sudah dibayar hubungi 0821821121212 dan bawa struk ke lapangan</p>
    </div>


    <!-- ... (konten lainnya) -->
</body>

</html>