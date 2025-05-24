<?php include 'koneksi.php';
session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - Unilever Style</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0f7ff, #ffffff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 12px;
            padding: 14px;
        }

        .btn-primary {
            background-color: #0077c8;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #005fa3;
        }

        .login-header {
            font-weight: bold;
            color: #0077c8;
        }

        .form-text a {
            text-decoration: none;
            color: #0077c8;
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
                <div class="card p-4">
                    <h3 class="text-center login-header mb-4">Login Akun</h3>
                    <form method="post">
                        <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
                        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                        <button type="submit" name="login" class="btn btn-primary w-100">Masuk</button>
                    </form>
                    <p class="form-text text-center mt-3">
                        Belum punya akun? <a href="register.php">Daftar di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if ($data && password_verify($password, $data['password'])) {
            $_SESSION['id'] = $data['id'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = $data['role'];

            if ($data['role'] == 'admin') {
                header("Location: admin/dashboard_admin.php");
            } else {
                header("Location: mulai_kuisioner.php");
            }
        } else {
            echo "<script>alert('Login gagal: username atau password salah');</script>";
        }
    }
    ?>
</body>

</html>