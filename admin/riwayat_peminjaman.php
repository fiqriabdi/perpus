<?php
session_start();
require '../config/koneksi.php';
if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-size: 0.9rem; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="bi bi-clock-history me-2"></i>Riwayat Peminjaman</h4>
            <a href="index.php" class="btn btn-warning btn-sm">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>User</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($riwayat)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['username']); ?></td>
                            <td><?= htmlspecialchars($row['judul']); ?></td>
                            <td class="text-center"><?= $row['tgl_pinjam']; ?></td>
                            <td class="text-center"><?= $row['tgl_balik'] ?? '-'; ?></td>
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
    </div>
</body>
</html>
