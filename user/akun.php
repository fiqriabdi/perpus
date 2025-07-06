<?php
session_start();
require '../config/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_SESSION['id_users'];
$user = mysqli_query($conn, "SELECT * FROM users WHERE id_users = $id");
$data = mysqli_fetch_assoc($user);

// Proses update
if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    mysqli_query($conn, "UPDATE users SET username = '$username', password = '$password' WHERE id_users = $id");
    $_SESSION['username'] = $username;

    echo "<script>alert('Profil berhasil diperbarui!'); location.href='index.php';</script>";
}

// Proses hapus
if (isset($_POST['hapus'])) {
    mysqli_query($conn, "DELETE FROM users WHERE id_users = $id");
    session_destroy();
    echo "<script>alert('Akun berhasil dihapus'); location.href='../auth/login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .btn-spacing {
            margin-bottom: 6px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <!-- Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Kelola Akun</h5>
                </div>
                <div class="card-body">
                    <!-- Form Update -->
                    <form method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($data['username']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="text" class="form-control" id="password" name="password" value="<?= htmlspecialchars($data['password']); ?>" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="update" class="btn btn-success btn-spacing">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <a href="index.php" class="btn btn-secondary btn-spacing">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                        </div>
                    </form>

                    <!-- Tombol Hapus -->
                    <form method="post" class="mt-2">
                        <div class="d-grid">
                            <button type="submit" name="hapus" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin menghapus akun ini?')">
                                <i class="bi bi-trash3"></i> Hapus Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>  
        </div>
    </div>
</div>

</body>
</html>
