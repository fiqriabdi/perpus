<?php
session_start();
require '../config/koneksi.php';

// Cek apakah user sudah login dan memiliki role 'user'
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php"); // Jika tidak, alihkan ke halaman login
    exit;
}

// Ambil ID user dari session
$id_users = $_SESSION['id_users'];

// Ambil riwayat peminjaman dari database berdasarkan id_users
$riwayat = mysqli_query($conn, "
    SELECT b.judul, p.tgl_pinjam, p.tgl_balik, p.status
    FROM peminjaman p
    JOIN books b ON p.id_buku = b.id_buku
    WHERE p.id_users = $id_users
    ORDER BY p.id_peminjaman DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman</title>
    <!-- Link ke Bootstrap dan ikon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <!-- Header dan tombol navigasi -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0"><i class="bi bi-clock-history me-2"></i>Riwayat Peminjaman</h3>
        <div>
            <a href="index.php" class="btn btn-outline-warning btn-sm me-2"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
            <a href="../auth/logout.php" class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>

    <!-- Tampilkan pesan jika tidak ada riwayat -->
    <?php if (mysqli_num_rows($riwayat) === 0): ?>
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle"></i> Belum ada riwayat peminjaman.
        </div>
    <?php else: ?>
        <!-- Tabel riwayat peminjaman -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th><i class="bi bi-book"></i> Judul Buku</th>
                        <th><i class="bi bi-clock"></i> Tanggal Pinjam</th>
                        <th><i class="bi bi-calendar-check"></i> Tanggal Kembali</th>
                        <th><i class="bi bi-info-circle"></i> Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($riwayat)) : ?>
                        <tr>
                            <!-- Judul buku -->
                            <td><?= htmlspecialchars($row['judul']); ?></td>

                            <!-- Tanggal pinjam -->
                            <td class="text-center"><?= $row['tgl_pinjam']; ?></td>

                            <!-- Tanggal kembali (jika null, tampilkan "-") -->
                            <td class="text-center"><?= $row['tgl_balik'] ?? '-'; ?></td>

                            <!-- Status dengan badge warna -->
                            <td class="text-center">
                                <?php
                                $status = $row['status'];
                                if ($status === 'dipinjam') {
                                    echo '<span class="badge bg-warning text-dark">Dipinjam</span>';
                                } elseif ($status === 'dikembalikan') {
                                    echo '<span class="badge bg-success">Dikembalikan</span>';
                                } elseif ($status === 'pending') {
                                    echo '<span class="badge bg-secondary">Pending</span>';
                                } else {
                                    echo '<span class="badge bg-dark">Tidak Diketahui</span>';
                                }
                                ?>
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
