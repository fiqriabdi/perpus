<?php
session_start();
require '../config/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$keyword = '';
if (isset($_GET['cari'])) {
    $keyword = $_GET['keyword'];
    $query = "SELECT * FROM books 
              WHERE stok > 0 AND (judul LIKE '$keyword%' OR penulis LIKE '$keyword%') 
              ORDER BY judul ASC";
} else {
    $query = "SELECT * FROM books WHERE stok > 0 ORDER BY judul ASC";
}
$buku = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .book-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .book-img {
            height: 200px;
            object-fit: contain;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-person-circle me-2"></i>Halo, <?= htmlspecialchars($_SESSION['username']); ?>!</h2>
        <div>
            <a href="dipinjam.php" class="btn btn-outline-primary btn-sm me-1"><i class="bi bi-bookmark-check"></i> Dipinjam</a>
            <a href="riwayat.php" class="btn btn-outline-secondary btn-sm me-1"><i class="bi bi-clock-history"></i> Riwayat</a>
            <a href="akun.php" class="btn btn-outline-info btn-sm me-1"><i class="bi bi-gear"></i> Akun</a>
            <a href="../auth/logout.php" class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>

    <!-- Form Pencarian -->
    <form class="mb-4" method="get">
        <div class="input-group">
            <input type="text" class="form-control" name="keyword" placeholder="Cari judul atau penulis..." value="<?= htmlspecialchars($keyword); ?>">
            <button class="btn btn-primary" type="submit" name="cari"><i class="bi bi-search"></i> Cari</button>
        </div>
    </form>

    <h4 class="mb-3"><i class="bi bi-book me-2"></i>Daftar Buku Tersedia</h4>

    <div class="row">
        <?php if (mysqli_num_rows($buku) === 0): ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">Buku tidak ditemukan.</div>
            </div>
        <?php endif; ?>

        <?php while ($row = mysqli_fetch_assoc($buku)) : ?>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card book-card h-100">
                    <a href="../assets/img/<?= $row['gambar']; ?>">
                    <img src="../assets/img/<?= $row['gambar']; ?>" class="card-img-top book-img" alt="<?= htmlspecialchars($row['judul']); ?>">
                    </a>

                   <div class="card-body d-flex flex-column">
    <h6 class="card-title"><?= htmlspecialchars($row['judul']); ?></h6>
    <?php if (!empty($row['deskripsi'])): ?>
    <p class="small text-muted mb-2"><?= htmlspecialchars(mb_strimwidth($row['deskripsi'], 0, 57, "...")); ?></p>
    <?php endif; ?>
    <p class="text-muted mb-1"><i class="bi bi-person-fill"></i> <?= htmlspecialchars($row['penulis']); ?></p>
    <p class="mb-2"><i class="bi bi-stack"></i> Stok: <strong><?= $row['stok']; ?></strong></p>

    <form action="../proses/proses_pinjam.php" method="post" class="mt-auto">
        <input type="hidden" name="id_buku" value="<?= $row['id_buku']; ?>">
        <button type="submit" name="pinjam" class="btn btn-success w-100 btn-sm">
            <i class="bi bi-cart-plus"></i> Pinjam
        </button>
    </form>
</div>

                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>
