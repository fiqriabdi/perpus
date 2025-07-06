<?php
require '../config/koneksi.php';
$hasil = mysqli_query($conn, "SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Buku</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    .card:hover {
  transform: scale(1.02);
  transition: 0.3s ease;
  box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.15);
}

    .card-img-top {
     
      height: outo;
      object-fit: cover;
    }
  </style>
</head>
<body>

<section class="container mt-5 mb-5">
  <h2 class="text-center mb-5 fw-bold text-primary">Daftar Buku</h2>
  <div class="row g-4">

    <?php while ($row = mysqli_fetch_assoc($hasil)) : ?>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">  <!-- Grid ini membuat tampilan lebih responsif di semua ukuran layar -->
      <div class="card h-100 shadow border-0 rounded-4 overflow-hidden">

        <?php 
          $gambar = !empty($row['gambar']) ? $row['gambar'] : 'default.png'; 
        ?>
        <img src="../assets/img/<?= htmlspecialchars($gambar) ?>" 
             class="card-img-top img-fluid" 
             alt="Cover Buku">

        <div class="card-body d-flex flex-column px-4 pb-4">
          <h5 class="card-title fw-semibold text-dark mb-2"><?= htmlspecialchars($row['judul']) ?></h5>
          <p class="card-text text-muted small mb-3">ID Buku: <?= htmlspecialchars($row['id_buku']) ?></p>

          <div class="mt-auto">
            <a href="detail.php?id=<?= $row['id_buku'] ?>" 
               class="btn btn-outline-info btn-sm w-100 mb-2 rounded-pill">
              <i class="bi bi-info-circle"></i> Lihat Detail
            </a>

            <?php if (!empty($row['file_buku'])) : ?>
              <!-- Tombol Baca Buku dengan modal preview -->
              <button type="button" class="btn btn-primary btn-sm w-100 rounded-pill" 
                      data-bs-toggle="modal" data-bs-target="#previewModal<?= $row['id_buku'] ?>">
                <i class="bi bi-file-earmark-pdf"></i> Baca Buku
              </button>

              <!-- Modal untuk Preview PDF -->
              <div class="modal fade" id="previewModal<?= $row['id_buku'] ?>" tabindex="-1" aria-labelledby="previewLabel<?= $row['id_buku'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="previewLabel<?= $row['id_buku'] ?>">Preview: <?= htmlspecialchars($row['judul']) ?></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body" style="height: 80vh;">
                      <iframe src="../uploads/<?= htmlspecialchars($row['file_buku']) ?>" 
                              width="100%" height="100%" style="border:none;"></iframe>
                    </div>
                  </div>
                </div>
              </div>
            <?php else : ?>
              <button class="btn btn-secondary btn-sm w-100 rounded-pill" disabled>
                <i class="bi bi-exclamation-circle"></i> Tidak ada isi 
              </button>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <?php endwhile; ?>

  </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
