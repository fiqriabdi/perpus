<?php
// Mulai sesi
session_start();

// Panggil file koneksi database
require '../config/koneksi.php';

// Cek apakah user bukan admin
// Jika iya, arahkan ke halaman login
if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Ambil data peminjaman yang status-nya masih "pending" (belum dikembalikan)
// Gabungkan dengan tabel users dan books untuk mendapatkan info lengkap
$peminjaman = mysqli_query($conn, "
    SELECT p.id_peminjaman, u.username, b.judul, p.tgl_pinjam 
    FROM peminjaman p
    JOIN users u ON p.id_users = u.id_users
    JOIN books b ON p.id_buku = b.id_buku
    WHERE p.status = 'pending'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pengembalian</title>

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

    <!-- Header dan tombol navigasi -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="bi bi-check2-square me-2"></i>Konfirmasi Pengembalian
        </h4>
        <div>
            <!-- Kembali ke dashboard -->
            <a href="index.php" class="btn btn-warning btn-sm me-2">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
            <!-- Logout -->
            <a href="../auth/logout.php" class="btn btn-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>

    <!-- Jika tidak ada data peminjaman yang pending -->
    <?php if (mysqli_num_rows($peminjaman) === 0): ?>
        <div class="alert alert-info text-center">
            Tidak ada permintaan pengembalian yang menunggu konfirmasi.
        </div>

    <!-- Jika ada data peminjaman -->
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <!-- Header tabel -->
                <thead class="table-primary text-center">
                    <tr>
                        <th>User</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <!-- Isi tabel -->
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($peminjaman)) : ?>
                        <tr>
                            <!-- Nama pengguna -->
                            <td><?= htmlspecialchars($row['username']); ?></td>
                            <!-- Judul buku -->
                            <td><?= htmlspecialchars($row['judul']); ?></td>
                            <!-- Tanggal peminjaman -->
                            <td class="text-center"><?= $row['tgl_pinjam']; ?></td>
                            <!-- Tombol konfirmasi pengembalian -->
                            <td class="text-center">
                                <form method="post" action="../proses/proses_konfirmasi.php" class="d-inline">
                                    <!-- Kirim ID peminjaman -->
                                    <input type="hidden" name="id_peminjaman" value="<?= $row['id_peminjaman']; ?>">
                                    <button type="submit" name="konfirmasi" class="btn btn-success btn-sm">
                                        <i class="bi bi-check-circle"></i> Konfirmasi
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
