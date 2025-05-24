<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Mulai Kuisioner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #005BAC, #0078D7);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            background-color: #ffffff;
            width: 100%;
            max-width: 500px;
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

        .btn-secondary {
            border-radius: 30px;
            padding: 0.6rem 1.5rem;
        }

        h3 {
            color: #005BAC;
        }

        .icon {
            font-size: 3rem;
            color: #0078D7;
        }
    </style>
</head>

<body>
    <div class="card text-center">
        <div class="mb-3">
            <i class="bi bi-ui-checks icon"></i>
        </div>
        <h3 class="mb-3">Mulai Kuisioner Produk Unilever</h3>
        <p>Apakah Anda yakin ingin mulai mengisi kuisioner?</p>
        <div class="d-grid gap-2 mt-4">
            <a href="biodata.php" class="btn btn-primary">Ya, Mulai</a>
            <a href="login.php" class="btn btn-secondary">Tidak, Kembali</a>
        </div>
    </div>
</body>

</html>