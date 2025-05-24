<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location:login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #003f7d, #0057a3);
            color: white;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: #002b5b;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.3rem;
        }

        .card {
            border: none;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 1.1rem;
            color: #003f7d;
        }

        .card-text {
            font-size: 0.9rem;
            color: #555;
        }

        .bg-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
        }

        footer {
            background-color: #001c3e;
            color: #ccc;
        }

        .logout-btn {
            border-radius: 12px;
        }

        .logo {
            width: 100%;
            /* atau gunakan max-width: 150px; */

        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm py-3">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="gambar2.png" alt="Logo" width="40" height="40" class="me-2 logo">

            </a>
            <div class="d-flex align-items-center">
                <span class="me-3 d-none d-md-block">👋 Halo, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="../logout.php" class="btn btn-outline-light logout-btn">Logout</a>

            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="bg-glass shadow">
            <h3 class="mb-3 fw-bold text-white">Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?> 👋</h3>
            <p class="lead text-white-50">Kelola data kuisioner dan akun pengguna dari satu tempat yang terorganisir.</p>

            <div class="row mt-4 g-4">
                <!-- Cards Menu -->
                <?php
                $menu = [
                    ["📋", "Kelola Pertanyaan", "Tambahkan, edit, atau hapus pertanyaan kuisioner.", "kelola_pertanyaan.php"],
                    ["💬", "Jawaban Pengguna", "Lihat hasil respon pengguna dari kuisioner.", "kelola_jawaban.php"],
                    ["👥", "Kelola Akun", "Lihat daftar akun dan ubah peran.", "kelola_akun.php"],
                    ["📊", "Analisis NPS", "Lihat hasil Net Promoter Score untuk produk.", "analisis_nps.php"],
                    ["⭐", "Rekomendasi Produk", "Berikan saran produk berdasarkan data.", "rekomendasi_produk.php"],
                    ["📄", "Laporan Admin", "Unduh laporan dalam format PDF/Excel.", "laporan_admin.php"],
                ];

                foreach ($menu as $item) {
                    echo '
                    <div class="col-md-6 col-lg-4">
                        <a href="' . $item[3] . '" class="text-decoration-none">
                            <div class="card bg-white shadow-sm h-100 rounded-4 p-3">
                                <div class="card-body text-center">
                                    <div class="mb-2 display-5">' . $item[0] . '</div>
                                    <h5 class="card-title fw-semibold">' . $item[1] . '</h5>
                                    <p class="card-text small">' . $item[2] . '</p>
                                </div>
                            </div>
                        </a>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>

    <footer class="mt-5 py-4 shadow-sm text-center">
        <div class="container">
            <p class="mb-2">© <?= date("Y") ?> Unilever Admin Panel. All rights reserved.</p>
            <a href="#" class="text-white text-decoration-none me-3">Kebijakan Privasi</a>
            <a href="#" class="text-white text-decoration-none">Kontak</a>
        </div>
    </footer>
</body>

</html>