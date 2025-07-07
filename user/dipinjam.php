<?php
// Mulai session
session_start();

// Koneksi ke database
require '../config/koneksi.php';

// Set zona waktu
date_default_timezone_set('Asia/Jakarta');

// Ambil jam saat ini
$jam = date("H:i:s");

// Cek apakah user sudah login dan rolenya 'user'
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

// Ambil ID user dari session
$id_users = $_SESSION['id_users'];

// Ambil daftar buku yang sedang dipinjam user
$peminjaman = mysqli_query($conn, "
    SELECT p.id_peminjaman, b.judul, p.tgl_pinjam
    FROM peminjaman p
    JOIN books b ON p.id_buku = b.id_buku
    WHERE p.id_users = $id_users AND p.status = 'dipinjam'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku yang Dipinjam</title>
    <!-- Bootstrap & Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <!-- Header dan navigasi -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0"><i class="bi bi-bookmark-check me-2"></i>Buku yang Sedang Dipinjam</h3>
        <div>
            <a href="index.php" class="btn btn-outline-warning btn-sm me-2"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
            <a href="../auth/logout.php" class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>

    <!-- Tampilkan pesan jika tidak ada buku -->
    <?php if (mysqli_num_rows($peminjaman) === 0): ?>
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-1"></i> Tidak ada buku yang sedang dipinjam.
        </div>

    <!-- Tampilkan daftar buku yang sedang dipinjam -->
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th><i class="bi bi-book"></i> Judul Buku</th>
                        <th><i class="bi bi-clock"></i> Tanggal Pinjam</th>
                        <th><i class="bi bi-arrow-return-left"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($peminjaman)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['judul']); ?></td>
                            <td class="text-center"><?= $row['tgl_pinjam']; ?> / <?= $jam; ?></td>
                            <td class="text-center">
                                <!-- Tombol kembalikan buku -->
                                <form method="post" action="../proses/proses_kembali.php" class="d-inline">
                                    <input type="hidden" name="id_peminjaman" value="<?= $row['id_peminjaman']; ?>">
                                    <button type="submit" name="kembalikan" class="btn btn-success btn-sm">
                                        <i class="bi bi-arrow-return-left"></i> Kembalikan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
