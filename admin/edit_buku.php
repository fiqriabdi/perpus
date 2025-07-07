<?php
// Mulai sesi
session_start();

// Memanggil file koneksi database
require '../config/koneksi.php';

// Mengecek apakah user yang login bukan admin
// Jika bukan, arahkan ke halaman login
if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Mengambil data buku berdasarkan ID yang dikirim lewat URL (GET)
$id = $_GET['id'];
$buku = mysqli_query($conn, "SELECT * FROM books WHERE id_buku = $id");
$data = mysqli_fetch_assoc($buku); // Mengubah hasil query menjadi array asosiatif
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-size: 0.9rem; } /* Ukuran font default */
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-2">
                    <h6 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Buku</h6>
                </div>
                <div class="card-body small">
                    <!-- Form untuk mengedit buku -->
                    <form action="../proses/proses_buku.php" method="post" enctype="multipart/form-data">
                        <!-- Menyimpan ID buku sebagai input tersembunyi -->
                        <input type="hidden" name="id_buku" value="<?= $data['id_buku']; ?>">
                        <!-- Menyimpan nama gambar lama untuk dihapus jika diubah -->
                        <input type="hidden" name="gambar_lama" value="<?= $data['gambar']; ?>">

                        <!-- Input judul buku -->
                        <div class="mb-2">
                            <label for="judul" class="form-label">Judul Buku</label>
                            <input type="text" class="form-control form-control-sm" id="judul" name="judul" value="<?= htmlspecialchars($data['judul']); ?>" required>
                        </div>

                        <!-- Input nama penulis -->
                        <div class="mb-2">
                            <label for="penulis" class="form-label">Penulis</label>
                            <input type="text" class="form-control form-control-sm" id="penulis" name="penulis" value="<?= htmlspecialchars($data['penulis']); ?>" required>
                        </div>

                        <!-- Input deskripsi buku -->
                        <div class="mb-2">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control form-control-sm" id="deskripsi" name="deskripsi" rows="4" placeholder="Tulis deskripsi buku..."><?= htmlspecialchars($data['deskripsi'] ?? '') ?></textarea>
                        </div>

                        <!-- Input stok buku -->
                        <div class="mb-2">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control form-control-sm" id="stok" name="stok" value="<?= $data['stok']; ?>" required>
                        </div>

                        <!-- Menampilkan gambar saat ini -->
                        <div class="mb-2">
                            <label class="form-label">Gambar Saat Ini</label><br>
                            <img src="../assets/img/<?= $data['gambar']; ?>" alt="Cover" width="90" class="img-thumbnail">
                        </div>

                        <!-- Input untuk mengganti gambar (opsional) -->
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Ubah Gambar (opsional)</label>
                            <input class="form-control form-control-sm" type="file" id="gambar" name="gambar" accept="image/*">
                        </div>

                        <!-- Tombol aksi: Simpan & Kembali -->
                        <div class="d-grid gap-2">
                            <button type="submit" name="edit" class="btn btn-success btn-sm">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <a href="kelola_buku.php" class="btn btn-secondary btn-sm">
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
