<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css"><!-- Sesuaikan dengan lokasi berkas CSS Anda -->
</head>
<body>
  <header>
<nav>

<li>Salam Olahraga, <?php echo $_SESSION['username']; ?></li>
<button class="button"><a href="halamanuser.php">Home</a></button> 

</li>
</div>
<li><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <input type="submit" name="logout" value="Logout">
</form></li>
</nav>
</header>