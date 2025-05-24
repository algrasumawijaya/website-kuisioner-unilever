<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$query = $conn->query("SELECT id_user, jawaban FROM jawaban_kuisioner WHERE id_pertanyaan = 2");

$rekomendasiList = [];

while ($row = $query->fetch_assoc()) {
    $idUser = $row['id_user'];
    $score = intval($row['jawaban']);

    if ($score > 8) {
        $produk = "Produk A";
    } elseif ($score >= 5) {
        $produk = "Produk B";
    } else {
        $produk = "Produk C";
    }

    $rekomendasiList[] = [
        'id_user' => $idUser,
        'score' => $score,
        'produk' => $produk,
    ];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekomendasi Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background: linear-gradient(90deg, #003f7d, #005bac);
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 63, 125, 0.08);
            background-color: #ffffff;
        }

        .btn-outline-light {
            border-radius: 30px;
        }

        .icon {
            font-size: 2rem;
            color: #005bac;
        }

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead {
            background-color: #005bac;
            color: white;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f9ff;
        }

        h3 {
            color: #003f7d;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Unilever Admin</a>
            <div class="d-flex">
                <a href="dashboard_admin.php" class="btn btn-outline-light d-flex align-items-center gap-2 px-4 py-2">
                    <i class="bi bi-arrow-left-circle-fill"></i> Kembali
                </a>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <div class="container py-5">
        <div class="card p-4">
            <div class="text-center mb-4">
                <i class="bi bi-stars icon mb-3"></i>
                <h3 class="fw-bold">Rekomendasi Produk Berdasarkan Kepuasan</h3>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No.</th>
                            <th>ID User</th>
                            <th>Skor Kepuasan</th>
                            <th>Rekomendasi Produk</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($rekomendasiList) > 0): ?>
                            <?php foreach ($rekomendasiList as $i => $item): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($item['id_user']) ?></td>
                                    <td><?= $item['score'] ?></td>
                                    <td><?= $item['produk'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data rekomendasi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>