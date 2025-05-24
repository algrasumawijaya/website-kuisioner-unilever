<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id_jawaban = intval($_GET['hapus']);
    $stmt = $conn->prepare("DELETE FROM jawaban_kuisioner WHERE id = ?");
    $stmt->bind_param('i', $id_jawaban);
    $stmt->execute();
    $stmt->close();
    header("Location: kelola_jawaban.php");
    exit;
}

if (isset($_GET['download_excel'])) {
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=jawaban_kuisioner.xls");

    echo "<table border='1'>
        <tr>
            <th>Nama</th><th>Usia</th><th>Jenis Kelamin</th><th>Pekerjaan</th>
            <th>Pertanyaan</th><th>Jenis</th><th>Jawaban</th>
        </tr>";

    $sql = "
        SELECT 
            biodata.nama, biodata.usia, biodata.jenis_kelamin, biodata.pekerjaan,
            pertanyaan.isi_pertanyaan, pertanyaan.jenis,
            jawaban_kuisioner.jawaban
        FROM jawaban_kuisioner
        JOIN users ON jawaban_kuisioner.id_user = users.id
        JOIN biodata ON users.id = biodata.id_user
        JOIN pertanyaan ON jawaban_kuisioner.id_pertanyaan = pertanyaan.id
        ORDER BY users.id, pertanyaan.id";

    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . htmlspecialchars($row['nama']) . "</td>
            <td>" . htmlspecialchars($row['usia']) . "</td>
            <td>" . htmlspecialchars($row['jenis_kelamin']) . "</td>
            <td>" . htmlspecialchars($row['pekerjaan']) . "</td>
            <td>" . htmlspecialchars($row['isi_pertanyaan']) . "</td>
            <td>" . htmlspecialchars($row['jenis']) . "</td>
            <td>" . htmlspecialchars($row['jawaban']) . "</td>
        </tr>";
    }

    echo "</table>";
    exit;
}

$sql = "
    SELECT 
        jawaban_kuisioner.id AS id_jawaban,
        users.id AS id_user,
        biodata.nama, biodata.usia, biodata.jenis_kelamin, biodata.pekerjaan,
        pertanyaan.isi_pertanyaan, pertanyaan.jenis,
        jawaban_kuisioner.jawaban
    FROM jawaban_kuisioner
    JOIN users ON jawaban_kuisioner.id_user = users.id
    JOIN biodata ON users.id = biodata.id_user
    JOIN pertanyaan ON jawaban_kuisioner.id_pertanyaan = pertanyaan.id
    ORDER BY users.id, pertanyaan.id";

$data = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Kelola Jawaban - Admin Unilever</title>
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

        .btn-primary,
        .btn-success {
            background-color: #005BAC;
            border-color: #005BAC;
            border-radius: 50px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover,
        .btn-success:hover {
            background-color: #003f7d;
            border-color: #003f7d;
        }

        h3 {
            color: #005BAC;
        }

        .card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 6px 18px rgba(0, 91, 172, 0.15);
            background-color: #fff;
        }

        .table thead {
            background-color: #005BAC;
            color: white;
        }

        .table-hover tbody tr:hover {
            background-color: #e6f0ff;
        }

        footer {
            background-color: #005BAC;
        }

        .btn-outline-secondary {
            color: #005BAC;
            border-color: #005BAC;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background-color: #005BAC;
            color: #fff;
        }

        .text-start {
            text-align: left !important;
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-semibold text-primary">
                <i class="bi bi-chat-left-text me-2"></i>Kelola Jawaban Kuisioner
            </h3>
            <a href="?download_excel=1" class="btn btn-success shadow-sm rounded-pill px-4 d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-excel"></i> Download Excel
            </a>
        </div>

        <div class="card p-4">
            <div class="table-responsive rounded-3">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Usia</th>
                            <th>Jenis Kelamin</th>
                            <th>Pekerjaan</th>
                            <th class="text-start">Pertanyaan</th>
                            <th>Jenis</th>
                            <th class="text-start">Jawaban</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data && $data->num_rows > 0): ?>
                            <?php while ($row = $data->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nama']) ?></td>
                                    <td><?= htmlspecialchars($row['usia']) ?></td>
                                    <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
                                    <td><?= htmlspecialchars($row['pekerjaan']) ?></td>
                                    <td class="text-start"><?= htmlspecialchars($row['isi_pertanyaan']) ?></td>
                                    <td><?= htmlspecialchars($row['jenis']) ?></td>
                                    <td class="text-start"><?= htmlspecialchars($row['jawaban']) ?></td>
                                    <td>
                                        <a href="?hapus=<?= $row['id_jawaban'] ?>" class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('Yakin ingin menghapus jawaban ini?')">
                                            <i class="bi bi-trash3"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada data jawaban kuisioner.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>