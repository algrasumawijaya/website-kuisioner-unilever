<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Halaman User</title>
</head>

<body>
    <h2>Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?></h2>
    <p>Ini halaman untuk user biasa.</p>
    <a href="logout.php">Logout</a>
</body>

</html>