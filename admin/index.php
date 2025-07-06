<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-container {
            max-width: 500px;
            margin: auto;
            margin-top: 80px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="card shadow">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">
                    👋 Selamat datang, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>!
                </h5>
                <div class="list-group">
                    <a href="kelola_buku.php" class="list-group-item list-group-item-action">
                        <i class="bi bi-book-half me-2"></i> Kelola Buku
                    </a>
                    <a href="sedang_dipinjam.php" class="list-group-item list-group-item-action">
                        <i class="bi bi-arrow-left-right me-2"></i> Buku yang Sedang Dipinjam
                    </a>
                    <a href="riwayat_peminjaman.php" class="list-group-item list-group-item-action">
                        <i class="bi bi-clock-history me-2"></i> Riwayat Peminjaman
                    </a>
                    <a href="konfirmasi.php" class="list-group-item list-group-item-action">
                        <i class="bi bi-check2-square me-2"></i> Konfirmasi Pengembalian
                    </a>
                    <a href="../auth/logout.php" class="list-group-item list-group-item-action text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
