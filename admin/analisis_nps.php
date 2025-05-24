<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$query = $conn->query("SELECT jawaban FROM jawaban_kuisioner WHERE id_pertanyaan = 1");

$total = 0;
$promoters = 0;
$passives = 0;
$detractors = 0;

while ($row = $query->fetch_assoc()) {
    $score = intval($row['jawaban']);
    $total++;

    if ($score >= 9 && $score <= 10) {
        $promoters++;
    } elseif ($score >= 7 && $score <= 8) {
        $passives++;
    } else {
        $detractors++;
    }
}

$nps = $total > 0 ? round((($promoters - $detractors) / $total) * 100, 2) : 0;

function npsKategori($nps)
{
    if ($nps >= 75) return "Excellent";
    if ($nps >= 50) return "Good";
    if ($nps >= 0) return "Needs Improvement";
    return "Poor";
}

$kategori = npsKategori($nps);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Analisis NPS - Admin Unilever</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: linear-gradient(90deg, #004080, #005BAC);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 91, 172, 0.15);
            background-color: #fff;
        }

        .nps-value {
            font-size: 4rem;
            font-weight: 800;
            color: #0078d7;
        }

        .badge-nps {
            font-size: 1.1rem;
            padding: 0.6em 1.4em;
            border-radius: 30px;
            background-color: #d1e9ff;
            color: #004080;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .list-group-item {
            border: none;
            font-size: 1.1rem;
            padding-left: 0;
            padding-right: 0;
            color: #333;
        }

        .list-group-item strong {
            color: #005BAC;
        }

        .btn-outline-light {
            border-radius: 50px;
            font-weight: 600;
            padding: 0.5rem 1.8rem;
            letter-spacing: 0.05em;
            transition: background-color 0.3s ease;
        }

        .btn-outline-light:hover {
            background-color: #003f7d;
            color: #fff;
            border-color: #003f7d;
        }

        .icon {
            font-size: 3rem;
            color: #005BAC;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard_admin.php">Unilever Admin</a>
            <div class="d-flex">
                <a href="dashboard_admin.php" class="btn btn-outline-light rounded-pill">
                    <i class="bi bi-arrow-left-circle-fill me-2"></i>Kembali
                </a>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <div class="container py-5">
        <div class="card p-5 mx-auto" style="max-width: 520px;">
            <div class="text-center mb-4">
                <i class="bi bi-graph-up-arrow icon mb-3"></i>
                <h3 class="fw-semibold text-primary">Analisis Net Promoter Score (NPS)</h3>
            </div>

            <div class="text-center mb-4">
                <div class="nps-value"><?= $nps ?>%</div>
                <span class="badge-nps"><?= $kategori ?></span>
            </div>

            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><strong>Total Responden:</strong> <?= $total ?></li>
                <li class="list-group-item"><strong>Promoters (9–10):</strong> <?= $promoters ?></li>
                <li class="list-group-item"><strong>Passives (7–8):</strong> <?= $passives ?></li>
                <li class="list-group-item"><strong>Detractors (0–6):</strong> <?= $detractors ?></li>
            </ul>
        </div>
    </div>
</body>

</html>