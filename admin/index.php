<?php
session_start();

// Cek login dan role admin
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

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f4f6f9 0%, #dce3f0 100%);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }
        .navbar {
            background: linear-gradient(90deg, #0d6efd, #0049b7);
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .navbar-brand, .navbar-text {
            color: #fff !important;
        }
        .btn-logout {
            color: #0d6efd;
            background-color: #fff;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        .btn-logout:hover {
            background-color: #e2e6ea;
        }
        .welcome-card {
            background: linear-gradient(135deg, #ffffff, #f8f9fb);
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-10px);}
            to {opacity: 1; transform: translateY(0);}
        }
        .admin-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d6efd, #0049b7);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin: 0 auto 10px;
        }
        .list-group-item {
            border: none;
            border-radius: 10px;
            margin-bottom: 8px;
            transition: all 0.25s ease;
        }
        .list-group-item i {
            color: #0d6efd;
        }
        .list-group-item:hover {
            background-color: #0d6efd;
            color: white;
            transform: translateX(5px);
        }
        .list-group-item:hover i {
            color: white;
        }
        footer {
            text-align: center;
            margin-top: 40px;
            color: #777;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="#">
            <i class="bi bi-book-half me-1"></i> Admin Perpustakaan
        </a>
        <div class="ms-auto d-flex align-items-center">
            <span class="navbar-text me-3">
                👋 Halo, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>
            </span>
            <a href="../auth/logout.php" class="btn btn-logout btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</nav>

<!-- Konten utama -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card welcome-card shadow-sm text-center p-4">
                <div class="admin-avatar mb-3">
                    <i class="bi bi-person-fill"></i>
                </div>
                <h4 class="fw-bold mb-1">Selamat Datang, <?= htmlspecialchars($_SESSION['username']); ?>!</h4>
                <p class="text-muted mb-4">Kelola semua aktivitas perpustakaan dari panel ini.</p>

                <div class="list-group">
                    <a href="kelola_buku.php" class="list-group-item list-group-item-action">
                        <i class="bi bi-book-half me-2"></i> Kelola Buku
                    </a>

                    <a href="sedang_dipinjam.php" class="list-group-item list-group-item-action">
                        <i class="bi bi-arrow-left-right me-2"></i> Buku Sedang Dipinjam
                    </a>

                    <a href="riwayat_peminjaman.php" class="list-group-item list-group-item-action">
                        <i class="bi bi-clock-history me-2"></i> Riwayat Peminjaman
                    </a>

                    <a href="konfirmasi.php" class="list-group-item list-group-item-action">
                        <i class="bi bi-check2-square me-2"></i> Konfirmasi Pengembalian
                    </a>

                    <a href="kelola_user.php" class="list-group-item list-group-item-action">
                        <i class="bi bi-people-fill me-2"></i> Kelola Pengguna
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="mt-5">
