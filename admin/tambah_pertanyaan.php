<?php
include '../koneksi.php';
session_start();
if ($_SESSION['role'] != 'admin') header("Location: ../login.php");

if (isset($_POST['tambah'])) {
    $isi = $_POST['isi_pertanyaan'];

    $stmt = $conn->prepare("INSERT INTO pertanyaan (isi_pertanyaan, jenis) VALUES (?, 'pilihan_ganda')");
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("s", $isi);
    $stmt->execute();

    $id_pertanyaan = $stmt->insert_id;

    if (!empty($_POST['pilihan'])) {
        $stmt2 = $conn->prepare("INSERT INTO pilihan_jawaban (id_pertanyaan, jawaban) VALUES (?, ?)");
        if (!$stmt2) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        foreach ($_POST['pilihan'] as $pilihan) {
            $jawaban = trim($pilihan);
            if ($jawaban !== '') {
                $stmt2->bind_param("is", $id_pertanyaan, $jawaban);
                $stmt2->execute();
            }
        }
    }

    header("Location: kelola_pertanyaan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Tambah Pertanyaan Pilihan Ganda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h3>Tambah Pertanyaan Pilihan Ganda Baru</h3>
        <form method="post" id="formPertanyaan">
            <label for="isi_pertanyaan" class="form-label">Isi Pertanyaan</label>
            <textarea name="isi_pertanyaan" id="isi_pertanyaan" class="form-control mb-3" placeholder="Masukkan pertanyaan" required></textarea>

            <h5>Pilihan Jawaban</h5>
            <div id="pilihan-container">
                <div class="input-group mb-2 pilihan-item">
                    <input type="text" name="pilihan[]" class="form-control" placeholder="Pilihan 1" required />
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusPilihan(this)">Hapus</button>
                </div>
                <div class="input-group mb-2 pilihan-item">
                    <input type="text" name="pilihan[]" class="form-control" placeholder="Pilihan 2" required />
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusPilihan(this)">Hapus</button>
                </div>
            </div>

            <button type="button" class="btn btn-sm btn-primary mb-3" onclick="tambahPilihan()">Tambah Pilihan</button><br />

            <button type="submit" name="tambah" class="btn btn-success">Simpan</button>
            <a href="kelola_pertanyaan.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script>
        function tambahPilihan() {
            const container = document.getElementById('pilihan-container');
            const jumlahPilihan = container.querySelectorAll('.pilihan-item').length + 1;

            const div = document.createElement('div');
            div.className = 'input-group mb-2 pilihan-item';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'pilihan[]';
            input.className = 'form-control';
            input.placeholder = 'Pilihan ' + jumlahPilihan;
            input.required = true;

            const btnHapus = document.createElement('button');
            btnHapus.type = 'button';
            btnHapus.className = 'btn btn-danger btn-sm';
            btnHapus.textContent = 'Hapus';
            btnHapus.onclick = function() {
                hapusPilihan(btnHapus);
            };

            div.appendChild(input);
            div.appendChild(btnHapus);
            container.appendChild(div);
        }

        function hapusPilihan(button) {
            const container = document.getElementById('pilihan-container');
            const pilihanItems = container.querySelectorAll('.pilihan-item');

            if (pilihanItems.length > 2) {
                button.parentElement.remove();
                updatePlaceholder();
            } else {
                alert('Minimal harus ada 2 pilihan.');
            }
        }

        function updatePlaceholder() {
            const container = document.getElementById('pilihan-container');
            const pilihanItems = container.querySelectorAll('.pilihan-item');
            pilihanItems.forEach((div, index) => {
                const input = div.querySelector('input');
                input.placeholder = 'Pilihan ' + (index + 1);
            });
        }
    </script>
</body>

</html>