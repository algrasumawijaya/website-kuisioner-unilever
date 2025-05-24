<?php
include '../koneksi.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Akun - Admin Unilever</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: #005BAC;
        }

        h3 {
            color: #005BAC;
        }

        .btn-primary,
        .btn-warning,
        .btn-secondary {
            border-radius: 30px;
        }

        .btn-warning {
            background-color: #ffc107;
            border: none;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            border-radius: 30px;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
        }

        .table thead {
            background-color: #005BAC;
            color: white;
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background: linear-gradient(90deg, #004080, #005BAC);">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Unilever Admin</a>
            <div class="d-flex">
                <a href="dashboard_admin.php" class="btn btn-outline-light px-4 py-2 fw-semibold rounded-pill d-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left-circle-fill fs-5"></i> Kembali
                </a>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container py-5">
        <h3 class="fw-semibold mb-4"><i class="bi bi-people-fill me-2"></i>Kelola Akun Pengguna</h3>

        <div class="card p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="text-center">
                        <tr>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= htmlspecialchars($row['role']) ?></td>
                                <td>
                                    <a href="edit_akun.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm me-2">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <?php if ($row['id'] != $_SESSION['id']): ?>
                                        <a href="hapus_akun.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus akun ini?')" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash3-fill"></i> Hapus
                                        </a>
                                    <?php endif ?>
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