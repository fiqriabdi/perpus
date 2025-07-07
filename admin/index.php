<?php
// Mulai sesi
session_start();

// Mengecek apakah user belum login atau bukan admin
// Jika iya, redirect ke halaman login
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

    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Link Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Styling tambahan -->
    <style>
        body {
            background-color: #f8f9fa; /* Warna latar belakang abu-abu muda */
        }
        .dashboard-container {
            max-width: 500px;        /* Lebar maksimal dashboard */
            margin: auto;            /* Posisi tengah secara horizontal */
            margin-top: 80px;        /* Jarak dari atas */
        }
    </style>
</head>
<body>
    <!-- Kontainer utama dashboard -->
    <div class="dashboard-container">
        <div class="card shadow">
            <div class="card-body">

                <!-- Judul dashboard dan sapaan untuk admin -->
                <h5 class="card-title text-center mb-4">
                    👋 Selamat datang, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>!
                </h5>

                <!-- Daftar menu navigasi untuk admin -->
                <div class="list-group">
                    <!-- Link untuk mengelola buku -->
                    <a href="kelola_buku.php" class="list-group-item list-group-item-action">
                        <i class="bi bi-book-half me-2"></i> Kelola Buku
                    </a>

                    <!-- Link untuk melihat buku yang sedang dipinjam -->
                    <a href="sedang_dipinjam.php" class="list-group-item list-group-item-action">
                        <i class="bi bi-arrow-left-right me-2"></i> Buku yang Sedang Dipinjam
                    </a>

                    <!-- Link untuk melihat riwayat peminjaman -->
                    <a href="riwayat_peminjaman.php" class="list-group-item list-group-item-action">
                        <i class="bi bi-clock-history me-2"></i> Riwayat Peminjaman
                    </a>

                    <!-- Link untuk mengonfirmasi pengembalian buku -->
                    <a href="konfirmasi.php" class="list-group-item list-group-item-action">
                        <i class="bi bi-check2-square me-2"></i> Konfirmasi Pengembalian
                    </a>

                    <!-- Link untuk logout -->
                    <a href="../auth/logout.php" class="list-group-item list-group-item-action text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
