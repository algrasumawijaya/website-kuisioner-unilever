<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Registrasi - Unilever Style</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #005BAC, #0078D7);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            background: #ffffff;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 12px;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: #005BAC;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #004a93;
        }

        .register-header {
            font-weight: bold;
            color: #005BAC;
        }

        .form-text a {
            text-decoration: none;
            color: #005BAC;
        }

        .form-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <h3 class="text-center register-header mb-4">Buat Akun Baru</h3>
                    <form method="post">
                        <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
                        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                        <select name="role" class="form-select mb-3" required>
                            <option value="" disabled selected>Pilih Peran</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                        <button type="submit" name="register" class="btn btn-primary w-100">Daftar</button>
                    </form>
                    <p class="form-text text-center mt-3">
                        Sudah punya akun? <a href="login.php">Login di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $role = $_POST['role'];

        $check = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Username sudah terdaftar');</script>";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $password, $role);
            $stmt->execute();
            echo "<script>alert('Registrasi berhasil'); window.location='login.php';</script>";
        }
    }
    ?>
</body>

</html>