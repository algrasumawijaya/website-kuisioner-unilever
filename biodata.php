<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $usia = $_POST['usia'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $pekerjaan = $_POST['pekerjaan'];

    $stmt = $conn->prepare("INSERT INTO biodata (id_user, nama, usia, jenis_kelamin, pekerjaan) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isiss", $id_user, $nama, $usia, $jenis_kelamin, $pekerjaan);
    $stmt->execute();

    header("Location: kuisioner.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Isi Biodata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #005BAC, #0078D7);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 500px;
            width: 100%;
        }

        h3 {
            color: #005BAC;
        }

        .btn-primary {
            background-color: #005BAC;
            border-color: #005BAC;
            border-radius: 30px;
            padding: 0.6rem 1.5rem;
        }

        .btn-primary:hover {
            background-color: #004a93;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
        }

        .icon {
            font-size: 3rem;
            color: #0078D7;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="text-center mb-3">
            <i class="bi bi-person-circle icon"></i>
        </div>
        <h3 class="text-center mb-4">Isi Biodata Anda</h3>
        <form method="post">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="usia" class="form-label">Usia</label>
                <input type="number" name="usia" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                <input type="text" name="pekerjaan" class="form-control" required />
            </div>
            <div class="d-grid mt-4">
                <button type="submit" name="submit" class="btn btn-primary">Simpan dan Lanjut</button>
            </div>
        </form>
    </div>
</body>

</html>