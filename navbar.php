<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css"><!-- Sesuaikan dengan lokasi berkas CSS Anda -->
    <link rel="stylesheet" href="js/sweetalert2-11.10.1/package/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

</head>
<body>
  <header>
<nav>

<li>Salam Olahraga, <?php echo $_SESSION['username']; ?></li>

<li><a href="profiluser.php"><i class="bi bi-person-fill"></i>Saya</a>
</li>
</div>
<li><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <input type="submit" name="logout" value="Logout">
</form></li>
</nav>
</header>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>