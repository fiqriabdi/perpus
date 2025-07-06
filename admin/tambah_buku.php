<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-size: 0.9rem; }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white py-2">
                    <h6 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Buku Baru</h6>
                </div>
                <div class="card-body small">
                    <form action="../proses/proses_buku.php" method="post" enctype="multipart/form-data">
                        <div class="mb-2">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control form-control-sm" id="judul" name="judul" required>
                        </div>

                        <div class="mb-2">
                            <label for="penulis" class="form-label">Penulis</label>
                            <input type="text" class="form-control form-control-sm" id="penulis" name="penulis" required>
                        </div>

                        <!-- ✅ Deskripsi Buku -->
                        <div class="mb-2">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control form-control-sm" id="deskripsi" name="deskripsi" rows="4" placeholder="Tulis deskripsi buku..."></textarea>
                        </div>

                        <div class="mb-2">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control form-control-sm" id="stok" name="stok" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Buku</label>
                            <input type="file" class="form-control form-control-sm" id="gambar" name="gambar" accept="image/*" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="tambah" class="btn btn-success btn-sm">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <a href="index.php" class="btn btn-secondary btn-sm">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
