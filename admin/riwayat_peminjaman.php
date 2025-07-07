<?php
// Mulai sesi
session_start();

// Hubungkan dengan file koneksi database
require '../config/koneksi.php';

// Cek apakah user bukan admin, jika iya arahkan ke halaman login
if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Ambil data riwayat peminjaman dari database
// Gabungkan data dengan tabel books dan users menggunakan JOIN
// Urutkan berdasarkan ID peminjaman dari yang terbaru
$riwayat = mysqli_query($conn, "
    SELECT p.*, b.judul, u.username
    FROM peminjaman p
    JOIN books b ON p.id_buku = b.id_buku
    JOIN users u ON p.id_users = u.id_users
    ORDER BY p.id_peminjaman DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Styling tambahan -->
    <style>
        body { font-size: 0.9rem; } /* Ukuran font kecil */
    </style>
</head>
<body class="bg-light">

<!-- Kontainer utama -->
<div class="container py-4">

    <!-- Header dan tombol kembali -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><i class="bi bi-clock-history me-2"></i>Riwayat Peminjaman</h4>
        <!-- Tombol kembali ke dashboard -->
        <a href="index.php" class="btn btn-warning btn-sm">
            <i class="bi bi-arrow-left-circle"></i> Kembali
        </a>
    </div>

    <!-- Tabel riwayat peminjaman -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <!-- Header tabel -->
            <thead class="table-primary text-center">
                <tr>
                    <th>User</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>

            <!-- Isi tabel -->
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($riwayat)) : ?>
                    <tr>
                        <!-- Nama user yang meminjam -->
                        <td><?= htmlspecialchars($row['username']); ?></td>
                        <!-- Judul buku yang dipinjam -->
                        <td><?= htmlspecialchars($row['judul']); ?></td>
                        <!-- Tanggal peminjaman -->
                        <td class="text-center"><?= $row['tgl_pinjam']; ?></td>
                        <!-- Tanggal kembali, jika kosong tampilkan "-" -->
                        <td class="text-center"><?= $row['tgl_balik'] ?? '-'; ?></td>
                        <!-- Status peminjaman -->
                        <td class="text-center">
                            <?php
                            $status = $row['status'];
                            if ($status === 'dipinjam') {
                                // Status saat buku sedang dipinjam
                                echo '<span class="badge bg-warning text-dark">Dipinjam</span>';
                            } elseif ($status === 'dikembalikan') {
                                // Status saat buku sudah dikembalikan
                                echo '<span class="badge bg-success">Dikembalikan</span>';
                            } elseif ($status === 'pending') {
                                // Status saat pengembalian menunggu konfirmasi
                                echo '<span class="badge bg-secondary">Pending</span>';
                            } else {
                                // Jika status tidak dikenali
                                echo '<span class="badge bg-dark">Tidak Diketahui</span>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
