<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // sesuaikan jika ada password
$db   = 'db_kuisioner_unilever';

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
