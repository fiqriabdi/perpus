<?php
require '../config/koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$query = mysqli_query($conn, "SELECT * FROM books WHERE id_buku = $id");
$buku = mysqli_fetch_assoc($query);

if (!$buku) {
  echo "<h4>Buku tidak ditemukan.</h4>";
  exit;
}

$gambar = !empty($buku['gambar']) ? $buku['gambar'] : 'default.png';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Buku - <?= htmlspecialchars($buku['judul']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
  <div class="row g-5">
    <div class="col-md-5">
      <img src="../assets/img/<?= htmlspecialchars($gambar) ?>" class="img-fluid rounded shadow" alt="Cover Buku">
    </div>
    <div class="col-md-7">
      <h2 class="fw-bold"><?= htmlspecialchars($buku['judul']) ?></h2>
      <p class="text-muted mb-2"><i class="bi bi-person-fill"></i> Penulis: <?= htmlspecialchars($buku['penulis']) ?></p>
      <?php if (!empty($buku['kategori'])): ?>
        <p class="text-muted mb-2"><i class="bi bi-tag"></i> Kategori: <?= htmlspecialchars($buku['kategori']) ?></p>
      <?php endif; ?>
      <p class="text-muted mb-2"><i class="bi bi-archive"></i> Stok: <?= (int)$buku['stok'] ?></p>

      <?php if (!empty($buku['file_buku'])): ?>
        <a href="../uploads/<?= htmlspecialchars($buku['file_buku']) ?>" class="btn btn-primary btn-sm mt-3" target="_blank">
          <i class="bi bi-file-earmark-pdf"></i> Baca Buku
        </a>
      <?php else: ?>
        <button class="btn btn-secondary btn-sm mt-3" disabled><i class="bi bi-file-earmark-x"></i> File tidak tersedia</button>
      <?php endif; ?>

      <hr>
      <h5 class="mt-4">Deskripsi Buku</h5>
      <p style="white-space: pre-wrap;"><?= nl2br(htmlspecialchars($buku['deskripsi'] ?? 'Belum ada deskripsi.')) ?></p>

      <a href="javascript:history.back()" class="btn btn-outline-secondary mt-4"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
