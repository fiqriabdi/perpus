<?php
session_start();
require '../config/koneksi.php';
if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$peminjaman = mysqli_query($conn, "
    SELECT p.*, b.judul, u.username
    FROM peminjaman p
    JOIN books b ON p.id_buku = b.id_buku
    JOIN users u ON p.id_users = u.id_users
    WHERE p.status = 'dipinjam'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku yang Sedang Dipinjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-size: 0.9rem; }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="bi bi-journal-bookmark-fill me-2"></i>
            Buku yang Sedang Dipinjam
        </h4>
        <a href="index.php" class="btn btn-warning btn-sm">
            <i class="bi bi-arrow-left-circle"></i> Kembali ke Menu
        </a>
    </div>

    <?php if (mysqli_num_rows($peminjaman) === 0): ?>
        <div class="alert alert-info text-center">Tidak ada buku yang sedang dipinjam saat ini.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>User</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($peminjaman)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['username']); ?></td>
                            <td><?= htmlspecialchars($row['judul']); ?></td>
                            <td class="text-center"><?= $row['tgl_pinjam']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
