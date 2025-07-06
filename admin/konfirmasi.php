<?php
session_start();
require '../config/koneksi.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-size: 0.9rem; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-check2-square me-2"></i>Konfirmasi Pengembalian
            </h4>
            <div>
                <a href="index.php" class="btn btn-warning btn-sm me-2">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
                <a href="../auth/logout.php" class="btn btn-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>

        <?php if (mysqli_num_rows($peminjaman) === 0): ?>
            <div class="alert alert-info text-center">
                Tidak ada permintaan pengembalian yang menunggu konfirmasi.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>User</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($peminjaman)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row['username']); ?></td>
                                <td><?= htmlspecialchars($row['judul']); ?></td>
                                <td class="text-center"><?= $row['tgl_pinjam']; ?></td>
                                <td class="text-center">
                                    <form method="post" action="../proses/proses_konfirmasi.php" class="d-inline">
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
