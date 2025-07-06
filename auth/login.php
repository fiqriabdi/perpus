<?php
session_start();
require '../config/koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        if ($password === $data['password']) {
            $_SESSION['id_users'] = $data['id_users'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = $data['role'];

            if ($data['role'] == 'admin') {
                header("Location: ../admin/");
            } else {
                header("Location: ../user/");
            }
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-size: 0.9rem;
        }
        .login-container {
            max-width: 350px;
            margin: auto;
            margin-top: 50px;
        }
        .card-body {
            padding: 1.2rem;
        }
        .form-control, .btn {
            font-size: 0.9rem;
            padding: 0.4rem 0.75rem;
        }
        .bi-person-circle {
            font-size: 2.2rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="../assets/img/logo.png" alt="Logo" class="img-fluid mb-2" style="max-width: 100px;">
                    <!-- <i class="bi bi-person-circle text-primary"></i> -->
                    <h5 class="mt-2 mb-3" style="color: navy;">Login</h5>
                </div>

                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger py-1 mb-3"><?= $error; ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-2">
                        <label for="username" class="form-label mb-1">Username:</label>
                        <input type="text" name="username" id="username" class="form-control" required autofocus>
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label mb-1">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="d-grid mt-3">
                        <button type="submit" name="login" class="btn btn-primary">Login</button>
                    </div>
                </form>

                <p class="text-center mt-3 mb-1">
                    Belum punya akun? <a href="register.php">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
