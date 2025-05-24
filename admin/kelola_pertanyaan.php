<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
$result = $conn->query("SELECT * FROM pertanyaan");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Kelola Pertanyaan - Admin Unilever</title>
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
            letter-spacing: 0.05em;
        }

        h3 {
            color: #004080;
            font-weight: 700;
            letter-spacing: 0.04em;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0, 91, 172, 0.1);
            background-color: #fff;
        }

        .table thead {
            background-color: #005BAC;
            color: #fff;
            font-weight: 600;
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
            transition: background-color 0.25s ease;
        }

        .btn-success {
            background-color: #0078d7;
            border-color: #0078d7;
        }

        .btn-success:hover {
            background-color: #005bac;
            border-color: #005bac;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
            color: #212529;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #b02a37;
            border-color: #a52834;
        }

        .btn-outline-light {
            color: #fff;
            border-radius: 50px;
            font-weight: 600;
            padding: 0.5rem 1.8rem;
        }

        .btn-outline-light:hover {
            background-color: #003f7d;
            color: #fff !important;
            border-color: #003f7d;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        .table-hover tbody tr:hover {
            background-color: #e6f0ff;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard_admin.php">Unilever Admin</a>
            <div class="d-flex">
                <a href="dashboard_admin.php" class="btn btn-outline-light d-flex align-items-center gap-2 px-4 py-2">
                    <i class="bi bi-arrow-left-circle-fill fs-5"></i> Kembali
                </a>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold"><i class="bi bi-card-checklist me-2"></i>Kelola Pertanyaan</h3>
            <a href="tambah_pertanyaan.php" class="btn btn-success shadow-sm px-4 d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle fs-5"></i> Tambah Pertanyaan
            </a>
        </div>

        <div class="card p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-center">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th class="text-start">Pertanyaan</th>
                            <th style="width: 15%;">Jenis</th>
                            <th style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php $no = 1;
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="text-start"><?= htmlspecialchars($row['isi_pertanyaan']) ?></td>
                                <td><?= ucfirst($row['jenis']) ?></td>
                                <td>
                                    <a href="edit_pertanyaan.php?id=<?= $row['id'] ?>"
                                        class="btn btn-warning btn-sm shadow-sm px-3 me-2"
                                        title="Edit Pertanyaan">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <a href="hapus_pertanyaan.php?id=<?= $row['id'] ?>"
                                        class="btn btn-danger btn-sm shadow-sm px-3"
                                        onclick="return confirm('Yakin ingin menghapus pertanyaan ini?')"
                                        title="Hapus Pertanyaan">
                                        <i class="bi bi-trash3"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>