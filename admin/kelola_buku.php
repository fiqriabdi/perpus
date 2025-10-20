<?php
session_start();

// Cek login & role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Koneksi database
require '../config/koneksi.php';

// Ambil semua data buku, urutkan berdasarkan judul (A–Z)
$buku = mysqli_query($conn, "SELECT * FROM books ORDER BY judul ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Buku | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f9f9ff, #eef4ff);
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            border-radius: 12px;
        }

        .table-wrapper {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }

        .book-img {
            width: 60px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            transition: transform 0.2s ease;
        }

        .book-img:hover {
            transform: scale(1.1);
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        .btn-sm i {
            vertical-align: middle;
        }

        footer {
            text-align: center;
            font-size: 0.9em;
            color: #888;
            margin-top: 30px;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mt-3 mx-3 px-3 shadow-sm">
    <div class="container-fluid">
        <h5 class="text-white mb-0">
            📘 Kelola Buku - <span class="fw-semibold"><?= htmlspecialchars($_SESSION['username']); ?></span>
        </h5>

        <div class="d-flex gap-2">
            <a href="index.php" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left"></i> Dashboard
            </a>
            <a href="konfirmasi.php" class="btn btn-info btn-sm text-white">
                <i class="bi bi-check-circle"></i> Konfirmasi
            </a>
            <a href="tambah_buku.php" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah
            </a>
            <a href="../auth/logout.php" class="btn btn-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</nav>

<!-- ISI UTAMA -->
<div class="container my-4">
    <div class="table-wrapper">
        <h4 class="mb-3 text-primary fw-semibold"><i class="bi bi-journal-text me-2"></i>Daftar Buku</h4>
        <hr>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (mysqli_num_rows($buku) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($buku)) : ?>
                            <tr>
                                <td>
                                    <img src="../assets/img/<?= htmlspecialchars($row['gambar']); ?>" alt="Cover Buku" class="book-img">
                                </td>
                                <td class="text-start"><?= htmlspecialchars($row['judul']); ?></td>
                                <td><?= htmlspecialchars($row['penulis']); ?></td>
                                <td><?= htmlspecialchars($row['stok']); ?></td>
                                <td>
                                    <a href="edit_buku.php?id=<?= $row['id_buku']; ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <a href="../proses/proses_buku.php?hapus=<?= $row['id_buku']; ?>" 
                                       onclick="return confirm('Yakin ingin menghapus buku ini?')" 
                                       class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-muted py-4">
                                <i class="bi bi-emoji-frown"></i> Tidak ada data buku.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer>
    <p>© <?= date('Y'); ?> Sistem Perpustakaan | Dibuat dengan ❤️ oleh Admin</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
