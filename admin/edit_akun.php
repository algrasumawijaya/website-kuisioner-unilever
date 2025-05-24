<?php
include '../koneksi.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM users WHERE id = $id");
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET username=?, role=? WHERE id=?");
    $stmt->bind_param("ssi", $username, $role, $id);
    $stmt->execute();

    header("Location: kelola_akun.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Akun</title>
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

        .form-container {
            max-width: 600px;
            margin: auto;
        }

        .btn-primary {
            border-radius: 30px;
            background-color: #005BAC;
        }

        .btn-primary:hover {
            background-color: #004080;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background: linear-gradient(90deg, #004080, #005BAC);">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Unilever Admin</a>
            <div class="d-flex">
                <a href="kelola_akun.php" class="btn btn-outline-light px-4 py-2 fw-semibold rounded-pill d-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left-circle-fill fs-5"></i> Kembali
                </a>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container py-5">
        <div class="form-container">
            <h3 class="mb-4 text-center text-primary"><i class="bi bi-pencil-square me-2"></i>Edit Akun</h3>

            <div class="card p-4">
                <form method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($data['username']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role:</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="admin" <?= $data['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="user" <?= $data['role'] == 'user' ? 'selected' : '' ?>>User</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>