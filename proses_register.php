<?php
session_start();
include 'koneksi.php'; // Pastikan file ini benar koneksinya

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$nama = trim($_POST['nama']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$role = $_POST['role'];

// Validasi sederhana
if (empty($nama) || empty($email) || empty($password) || empty($role)) {
    $_SESSION['error'] = 'Semua field harus diisi.';
    header('Location: register.php');
    exit;
}

// Cek jika role admin harus pakai kode rahasia
if ($role === 'admin') {
    $admin_code = $_POST['admin_code'] ?? '';

    // Ganti kode rahasia di bawah ini sesuai yang kamu mau
    $SECRET_ADMIN_CODE = 'ADMIN2025';

    if ($admin_code !== $SECRET_ADMIN_CODE) {
        $_SESSION['error'] = 'Kode rahasia admin salah!';
        header('Location: register.php');
        exit;
    }
}

// Cek email sudah terdaftar belum
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $_SESSION['error'] = 'Email sudah terdaftar.';
    header('Location: register.php');
    exit;
}
$stmt->close();

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Simpan user baru
$stmt = $conn->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nama, $email, $hashed_password, $role);

if ($stmt->execute()) {
    $_SESSION['success'] = 'Registrasi berhasil! Silakan login.';
    header('Location: login.php');
} else {
    $_SESSION['error'] = 'Registrasi gagal. Silakan coba lagi.';
    header('Location: register.php');
}
$stmt->close();
$conn->close();
exit;
