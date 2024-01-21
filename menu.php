<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Tag head lainnya -->

    <!-- Menggunakan Bootstrap 5 (harap ganti versi jika Anda menggunakan versi yang berbeda) -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/menu.css">

</head>

<body>

    <div class="menudash">
        <ul style="padding-left: 10px; padding-right: 10px;">
            <li style="padding: 10px;"><a href="halamanadmin.php"> <span class="bi bi-list"></span> Daftar Booking</a>
            </li>
            <li style="padding-right: 10px;"><a href="halamanadmin.php?modul=datauser"> <span
                        class="bi bi-people-fill"></span> Daftar user</a></li>

            <!-- Menu Dropdown Pengaturan -->
            <li class="dropdown" style="padding-right: 10px; backgorund-color: none;">
                <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <span class="bi bi-gear-fill"></span> Pengaturan
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="halamanadmin.php?modul=admin_setting">Admin Setting</a>
                    <a class="dropdown-item" href="halamanadmin.php?modul=metodePembayaran">Metode Pembayaran</a>
                    <!-- Tambahkan opsi lain sesuai kebutuhan -->
                </div>
            </li>
            <!-- End Menu Dropdown Pengaturan -->

            <li style="padding-right: 10px;"><a href="halamanadmin.php?modul=dataadmin"> <span
                        class="bi bi-person-check-fill"></span> Daftar Admin </a></li>
        </ul>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>