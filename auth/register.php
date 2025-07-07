<?php
require '../config/koneksi.php'; // Menghubungkan ke file koneksi database

if (isset($_POST['register'])) { // Jika tombol "Daftar" ditekan
    $username = $_POST['username'];  // Tangkap input username dari form
    $password = $_POST['password'];  // Tangkap input password dari form

    // Cek apakah username sudah digunakan
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Username sudah digunakan."; // Tampilkan pesan error jika username sudah ada
    } else {
        // Jika belum ada, masukkan ke database
        $query = mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'user')");
        
        if ($query) {
            // Jika berhasil, redirect ke halaman login
            header("Location: login.php");
            exit;
        } else {
            // Jika gagal insert ke database
            $error = "Registrasi gagal. Coba lagi.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"> <!-- Menentukan charset -->
    <title>Register</title> <!-- Judul halaman -->
    
    <!-- Import Bootstrap & Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body { font-size: 0.9rem; } /* Ukuran font disesuaikan */
    </style>
</head>
<body class="bg-light"> <!-- Latar belakang abu muda -->

<!-- Form container -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4"> <!-- Ukuran kolom tengah -->
            <div class="card shadow-sm"> <!-- Kotak form -->
                <div class="card-header bg-primary text-white text-center"> <!-- Header -->
                    <h4><i class="bi bi-person-plus-fill me-1"></i> Register</h4>
                </div>
                
                <div class="card-body">
                    <!-- Tampilkan pesan error jika ada -->
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger text-center"><?= $error; ?></div>
                    <?php endif; ?>
                    
                    <!-- Form registrasi -->
                    <form method="post">
                        <!-- Username -->
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-grid">
                            <button type="submit" name="register" class="btn btn-primary">
                                <i class="bi bi-person-check"></i> Daftar
                            </button>
                        </div>
                    </form>

                    <!-- Link ke login -->
                    <p class="mt-3 text-center">
                        Sudah punya akun? <a href="login.php">Login di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
