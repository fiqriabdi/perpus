<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
require '../config/koneksi.php';

// Ambil semua buku
$buku = mysqli_query($conn, "SELECT * FROM books ORDER BY judul ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .book-img {
            width: 60px;
            height: auto;
            border-radius: 4px;
            
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>📚 Daftar Buku - Admin <span class="text-primary"><?= htmlspecialchars($_SESSION['username']); ?></span></h4>
        <div>
            <a href="index.php" class="btn btn-secondary btn-sm me-2"><i class="bi bi-arrow-left"></i> Kembali</a>
            <a href="konfirmasi.php" class="btn btn-info btn-sm me-2"><i class="bi bi-check-circle"></i> Konfirmasi</a>
            <a href="tambah_buku.php" class="btn btn-success btn-sm me-2"><i class="bi bi-plus-circle"></i> Tambah Buku</a>
            <a href="../auth/logout.php" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($buku)) : ?>
                    <tr>
                        <td class="text-center">
                            <img src="../assets/img/<?= $row['gambar']; ?>" class="book-img">
                        </td>
                        <td><?= htmlspecialchars($row['judul']); ?></td>
                        <td><?= htmlspecialchars($row['penulis']); ?></td>
                        <td class="text-center"><?= $row['stok']; ?></td>
                        <td class="text-center">
                            <a href="edit_buku.php?id=<?= $row['id_buku']; ?>" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="../proses/proses_buku.php?hapus=<?= $row['id_buku']; ?>" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-sm btn-danger">
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
