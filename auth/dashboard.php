<?php
require '../config/koneksi.php'; // koneksi ke database

// Inisialisasi variabel
$hasil = [];
$keyword = '';
$kolom = '';

// Proses pencarian jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $kolom = $_POST['kolom'];

    if ($kolom === 'judul') {
        $query = "SELECT * FROM books WHERE judul LIKE '$keyword%'";
    } elseif ($kolom === 'penulis') {
        $query = "SELECT * FROM books WHERE penulis LIKE '$keyword%'";
    } elseif ($kolom === 'isbn') {
        $query = "SELECT * FROM books WHERE judul LIKE '$keyword%' OR penulis LIKE '%$keyword%'"; // fallback
    } else {
        // Semua kolom
        $query = "SELECT * FROM books WHERE judul LIKE '$keyword' OR penulis LIKE '$keyword'";
    }

    $hasil = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Perpustakaan Digital</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="./dashboard.php">
      <img src="../assets/img/logo.png" alt="Logo" width="40" class="me-2">
      Tiga Sisi
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-4">
        <li class="nav-item"><a class="nav-link" href="buku.php"><i class="bi bi-book me-1"></i>Daftar Buku</a></li>
        <li class="nav-item"><a class="nav-link" href="panduan.php"><i class="bi bi-info-circle me-1"></i>Panduan</a></li>
        <li class="nav-item"><a class="nav-link" href="tentang.php"><i class="bi bi-people me-1"></i>Tentang Kami</a></li>
        <li class="nav-item"><a class="nav-link" href="kontak.php"><i class="bi bi-envelope me-1"></i>Kontak</a></li>
      </ul>
      <div class="ms-auto">
        <a href="login.php" class="btn btn-outline-main me-2 btn-sm">Masuk</a>
        <a href="register.php" class="btn btn-main btn-sm">Daftar</a>
      </div>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero pt-5 mt-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 animate__animated animate__fadeInLeft">
        <h1 class="hero-title mb-3">Selamat Datang di <span class="text-primary">Perpustakaan Digital</span></h1>
        <p class="hero-desc mb-4">Temukan jutaan koleksi dari perpustakaan, museum, dan arsip Indonesia dalam satu platform.</p>
        <form class="row g-2 search-box" method="post">
          <div class="col-sm-5">
            <input type="text" name="keyword" class="form-control" placeholder="Cari buku..." value="<?= htmlspecialchars($keyword) ?>">
          </div>
          <div class="col-sm-4">
            <select class="form-select" name="kolom">
              <option value="">Semua Kolom</option>
              <option value="judul" <?= $kolom === 'judul' ? 'selected' : '' ?>>Judul</option>
              <option value="penulis" <?= $kolom === 'penulis' ? 'selected' : '' ?>>Penulis</option>
              <option value="isbn" <?= $kolom === 'isbn' ? 'selected' : '' ?>>ISBN</option>
            </select>
          </div>
          <div class="col-sm-3">
            <button class="btn btn-main w-100"><i class="bi bi-search me-1"></i>Cari</button>
          </div>
        </form>
        <a href="#" class="d-block mt-2 text-primary small text-decoration-underline">Pencarian lanjutan</a>
      </div>
      <div class="col-md-6 text-center animate__animated animate__fadeInRight mt-4 mt-md-0">
        <img src="../assets/img/logo.png" alt="Ilustrasi" class="img-fluid img-hero">
      </div>
    </div>
  </div>
</section>

<!-- Hasil Pencarian -->
<?php if (!empty($hasil)) : ?>
<section class="container mt-5">
  <h5 class="mb-4">Hasil Pencarian</h5>
  <div class="row">
    <?php while ($row = mysqli_fetch_assoc($hasil)) : ?>
    <div class="col-md-4 mb-4">
      <div class="card h-100 shadow-sm">
        <img src="../assets/img/<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['judul']) ?>" style="height: 250px; object-fit: cover;">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
          <p class="card-text mb-1"><i class="bi bi-person-fill"></i> <?= htmlspecialchars($row['penulis']) ?></p>
          <p class="card-text text-muted">Stok: <?= $row['stok'] ?></p>
          <div class="mt-auto d-flex justify-content-between">
            <a href="detail.php?id=<?= $row['id_buku'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-info-circle"></i> Detail</a>
            <?php if ($row['stok'] > 0) : ?>
              <form method="post" action="../proses/proses_pinjam.php">
                <input type="hidden" name="id_buku" value="<?= $row['id_buku'] ?>">
                <button type="submit" name="pinjam" class="btn btn-sm btn-success"><i class="bi bi-bookmark-plus"></i> Pinjam</button>
              </form>
            <?php else : ?>
              <button class="btn btn-sm btn-secondary" disabled><i class="bi bi-x-circle"></i> Habis</button>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</section>
<?php endif; ?>



<!-- Footer -->
<footer class="text-center mt-5 mb-3">
  &copy; <?= date('Y') ?> Perpustakaan Digital
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
