<?php
include '../koneksi.php';
session_start();
if ($_SESSION['role'] != 'admin') header("Location: ../login.php");

$id = $_GET['id'];
$query = $conn->query("SELECT * FROM pertanyaan WHERE id = $id");
$data = $query->fetch_assoc();

if (isset($_POST['submit'])) {
    $isi = $_POST['isi_pertanyaan'];
    $jenis = $_POST['jenis'];
    $conn->query("UPDATE pertanyaan SET isi_pertanyaan='$isi', jenis='$jenis' WHERE id=$id");

    // Hapus pilihan lama (jika checkbox dihapus)
    if (isset($_POST['hapus_pilihan'])) {
        foreach ($_POST['hapus_pilihan'] as $id_pilihan) {
            $conn->query("DELETE FROM pilihan_jawaban WHERE id = $id_pilihan");
        }
    }

    // Update pilihan lama
    if (isset($_POST['pilihan_lama'])) {
        foreach ($_POST['pilihan_lama'] as $id_pilihan => $isi_pilihan) {
            $isi_pilihan = trim($isi_pilihan);
            if ($isi_pilihan != '') {
                $conn->query("UPDATE pilihan_jawaban SET jawaban = '$isi_pilihan' WHERE id = $id_pilihan");
            }
        }
    }

    // Tambah pilihan baru
    if (!empty($_POST['pilihan_baru'])) {
        foreach ($_POST['pilihan_baru'] as $pilihan_baru) {
            $pilihan_baru = trim($pilihan_baru);
            if ($pilihan_baru != '') {
                $conn->query("INSERT INTO pilihan_jawaban (id_pertanyaan, jawaban) VALUES ($id, '$pilihan_baru')");
            }
        }
    }

    header("Location: kelola_pertanyaan.php");
    exit;
}

// Ambil pilihan jawaban
$pilihan = $conn->query("SELECT * FROM pilihan_jawaban WHERE id_pertanyaan = $id");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Pertanyaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hapus-pilihan {
            color: red;
            cursor: pointer;
        }
    </style>
    <script>
        function tambahPilihan() {
            const container = document.getElementById('pilihan-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'pilihan_baru[]';
            input.className = 'form-control mb-2';
            input.placeholder = 'Pilihan jawaban baru';
            container.appendChild(input);
        }
    </script>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow p-4">
            <h4 class="mb-4 text-primary">Edit Pertanyaan</h4>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Isi Pertanyaan</label>
                    <input type="text" name="isi_pertanyaan" class="form-control" value="<?= htmlspecialchars($data['isi_pertanyaan']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Jawaban</label>
                    <select name="jenis" class="form-select" required>
                        <option value="opsi" <?= $data['jenis'] == 'opsi' ? 'selected' : '' ?>>Opsi Pilihan</option>
                        <option value="isian" <?= $data['jenis'] == 'isian' ? 'selected' : '' ?>>Isian Bebas</option>
                    </select>
                </div>

                <?php if ($data['jenis'] == 'opsi'): ?>
                    <div class="mb-3">
                        <label class="form-label">Daftar Pilihan Jawaban</label>
                        <div id="pilihan-container">
                            <?php while ($row = $pilihan->fetch_assoc()): ?>
                                <div class="input-group mb-2">
                                    <input type="text" name="pilihan_lama[<?= $row['id'] ?>]" class="form-control" value="<?= htmlspecialchars($row['jawaban']) ?>">
                                    <div class="input-group-text">
                                        <input type="checkbox" name="hapus_pilihan[]" value="<?= $row['id'] ?>">
                                        <small class="ms-1 text-danger">Hapus</small>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="tambahPilihan()">+ Tambah Pilihan</button>
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between mt-4">
                    <a href="kelola_pertanyaan.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>