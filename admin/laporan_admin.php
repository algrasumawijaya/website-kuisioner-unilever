<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Statistik: jumlah responden unik
$responden_count = $conn->query("SELECT COUNT(DISTINCT id_user) AS total FROM jawaban_kuisioner")->fetch_assoc()['total'] ?? 0;

// Statistik: distribusi jenis kelamin
$sql_gender = "
    SELECT biodata.jenis_kelamin, COUNT(DISTINCT biodata.id_user) AS jumlah
    FROM biodata
    JOIN jawaban_kuisioner ON biodata.id_user = jawaban_kuisioner.id_user
    GROUP BY biodata.jenis_kelamin
";
$result_gender = $conn->query($sql_gender);
$gender_data = [];
while ($row = $result_gender->fetch_assoc()) {
    $gender_data[$row['jenis_kelamin']] = $row['jumlah'];
}

// Statistik: rata-rata usia responden
$avg_age = $conn->query("
    SELECT AVG(biodata.usia) AS rata_rata_usia
    FROM biodata
    JOIN jawaban_kuisioner ON biodata.id_user = jawaban_kuisioner.id_user
")->fetch_assoc()['rata_rata_usia'] ?? 0;

// Statistik: jumlah jawaban per pertanyaan
$sql_jawaban_pertanyaan = "
    SELECT pertanyaan.isi_pertanyaan, COUNT(jawaban_kuisioner.id) AS jumlah_jawaban
    FROM pertanyaan
    LEFT JOIN jawaban_kuisioner ON pertanyaan.id = jawaban_kuisioner.id_pertanyaan
    GROUP BY pertanyaan.id
    ORDER BY pertanyaan.id
";
$result_jawaban_pertanyaan = $conn->query($sql_jawaban_pertanyaan);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Laporan Admin - Unilever</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background: linear-gradient(90deg, #004080, #005BAC);
        }

        h3,
        .card-title {
            color: #005BAC;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 91, 172, 0.1);
            background-color: #fff;
        }

        .btn-primary {
            background-color: #005BAC;
            border-color: #005BAC;
            border-radius: 50px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #003f7d;
            border-color: #003f7d;
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Unilever Admin</a>
            <div class="d-flex">
                <a href="dashboard_admin.php" class="btn btn-outline-light d-flex align-items-center gap-2 px-4 py-2 fw-semibold" style="border-radius: 50px;">
                    <i class="bi bi-arrow-left-circle-fill fs-5"></i> Kembali
                </a>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container py-5">
        <h3 class="fw-semibold mb-4"><i class="bi bi-file-earmark-text me-2"></i>Laporan Kuisioner</h3>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <h5 class="card-title">Jumlah Responden</h5>
                    <p class="display-4 text-primary fw-bold"><?= number_format($responden_count) ?></p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <h5 class="card-title">Rata-rata Usia Responden</h5>
                    <p class="display-5 text-primary fw-semibold"><?= number_format($avg_age, 1) ?> Tahun</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-4">
                    <h5 class="card-title mb-3 text-center">Distribusi Jenis Kelamin</h5>
                    <ul class="list-group">
                        <?php foreach ($gender_data as $gender => $jumlah): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= htmlspecialchars($gender) ?>
                                <span class="badge bg-primary rounded-pill"><?= $jumlah ?></span>
                            </li>
                        <?php endforeach; ?>
                        <?php if (empty($gender_data)): ?>
                            <li class="list-group-item text-center text-muted">Data tidak tersedia</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card mt-5 p-4">
            <h5 class="card-title mb-3">Jumlah Jawaban per Pertanyaan</h5>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>Pertanyaan</th>
                            <th>Jumlah Jawaban</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_jawaban_pertanyaan && $result_jawaban_pertanyaan->num_rows > 0): ?>
                            <?php $no = 1; ?>
                            <?php while ($row = $result_jawaban_pertanyaan->fetch_assoc()): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['isi_pertanyaan']) ?></td>
                                    <td class="text-center"><?= $row['jumlah_jawaban'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada data jawaban.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 text-end">
            <a href="kelola_jawaban.php?download_excel=1" class="btn btn-primary shadow-sm rounded-pill px-4 d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-excel"></i> Download Semua Jawaban Excel
            </a>
        </div>
    </div>
</body>

</html>