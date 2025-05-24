<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];
$pertanyaan = $conn->query("SELECT * FROM pertanyaan ORDER BY id");

if (isset($_POST['submit'])) {
    foreach ($_POST['jawaban'] as $id_pertanyaan => $id_pilihan) {
        $stmt_jawaban = $conn->prepare("SELECT jawaban FROM pilihan_jawaban WHERE id = ?");
        $stmt_jawaban->bind_param("i", $id_pilihan);
        $stmt_jawaban->execute();
        $stmt_jawaban->bind_result($jawaban_text);
        $stmt_jawaban->fetch();
        $stmt_jawaban->close();

        $stmt = $conn->prepare("INSERT INTO jawaban_kuisioner (id_user, id_pertanyaan, jawaban) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $id_user, $id_pertanyaan, $jawaban_text);
        $stmt->execute();
    }

    echo "<script>alert('Terima kasih telah mengisi kuisioner!'); window.location='login.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kuisioner Produk Unilever</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #005BAC, #0078D7);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #005BAC;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .question-block {
            margin-bottom: 2rem;
        }

        .form-check {
            margin-left: 1rem;
        }

        .btn-primary {
            background-color: #005BAC;
            border: none;
            border-radius: 30px;
            padding: 0.6rem 1.5rem;
        }

        .btn-primary:hover {
            background-color: #004a93;
        }
    </style>
</head>

<body>

    <div class="card">
        <h3>Kuisioner Produk Unilever</h3>
        <form method="post">
            <?php while ($row = $pertanyaan->fetch_assoc()): ?>
                <div class="question-block">
                    <p><strong><?= htmlspecialchars($row['isi_pertanyaan']) ?></strong></p>
                    <?php
                    $id_pertanyaan = $row['id'];
                    $opsi = $conn->query("SELECT * FROM pilihan_jawaban WHERE id_pertanyaan = $id_pertanyaan");
                    while ($pilihan = $opsi->fetch_assoc()):
                    ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio"
                                name="jawaban[<?= $id_pertanyaan ?>]"
                                value="<?= $pilihan['id'] ?>"
                                id="pilihan<?= $pilihan['id'] ?>" required>
                            <label class="form-check-label" for="pilihan<?= $pilihan['id'] ?>">
                                <?= htmlspecialchars($pilihan['jawaban']) ?>
                            </label>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endwhile; ?>
            <div class="d-grid">
                <button type="submit" name="submit" class="btn btn-primary">Kirim Jawaban</button>
            </div>
        </form>
    </div>

</body>

</html>