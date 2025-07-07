<?php
// Mulai sesi
session_start();

// Cek apakah user sudah login dan memiliki role admin
// Jika tidak, arahkan ke halaman login
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Panggil koneksi database
require '../config/koneksi.php';

// Ambil semua data buku dari database dan urutkan berdasarkan judul (ascending)
$buku = mysqli_query($conn, "SELECT * FROM books ORDER BY judul ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Buku</title>

    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link ke Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Styling untuk gambar buku -->
    <style>
        .book-img {
            width: 60px;         /* Lebar gambar */
            height: auto;        /* Tinggi otomatis menyesuaikan */
            border-radius: 4px;  /* Sedikit membulatkan sudut gambar */
        }
    </style>
</head>
<body class="bg-light">

<!-- Kontainer utama -->
<div class="container py-4">
    
    <!-- Header halaman dan tombol navigasi -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>
            📚 Daftar Buku - Admin 
            <span class="text-primary"><?= htmlspecialchars($_SESSION['username']); ?></span>
        </h4>

        <!-- Tombol navigasi -->
        <div>
            <!-- Kembali ke halaman dashboard -->
            <a href="index.php" class="btn btn-secondary btn-sm me-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <!-- Menuju ke halaman konfirmasi pengembalian -->
            <a href="konfirmasi.php" class="btn btn-info btn-sm me-2">
                <i class="bi bi-check-circle"></i> Konfirmasi
            </a>

            <!-- Menuju ke halaman tambah buku -->
            <a href="tambah_buku.php" class="btn btn-success btn-sm me-2">
                <i class="bi bi-plus-circle"></i> Tambah Buku
            </a>

            <!-- Tombol logout -->
            <a href="../auth/logout.php" class="btn btn-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>

    <!-- Tabel daftar buku -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <!-- Header tabel -->
            <thead class="table-primary text-center">
                <tr>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <!-- Isi tabel -->
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($buku)) : ?>
                    <tr>
                        <!-- Kolom gambar buku -->
                        <td class="text-center">
                            <img src="../assets/img/<?= $row['gambar']; ?>" class="book-img">
                        </td>

                        <!-- Kolom judul buku -->
                        <td><?= htmlspecialchars($row['judul']); ?></td>

                        <!-- Kolom nama penulis -->
                        <td><?= htmlspecialchars($row['penulis']); ?></td>

                        <!-- Kolom stok buku -->
                        <td class="text-center"><?= $row['stok']; ?></td>

                        <!-- Kolom aksi: edit dan hapus -->
                        <td class="text-center">
                            <!-- Tombol edit -->
                            <a href="edit_buku.php?id=<?= $row['id_buku']; ?>" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>

                            <!-- Tombol hapus dengan konfirmasi -->
                            <a href="../proses/proses_buku.php?hapus=<?= $row['id_buku']; ?>" 
                               onclick="return confirm('Yakin ingin hapus?')" 
                               class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
