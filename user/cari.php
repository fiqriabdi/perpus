<?php
// Mulai session
session_start();

// Koneksi ke database
require '../config/koneksi.php';

// Cek apakah user sudah login dengan role 'user'
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

// Inisialisasi variabel pencarian
$keyword = '';

// Cek apakah form pencarian dikirim
if (isset($_GET['cari'])) {
    $keyword = $_GET['keyword'];

    // Query pencarian berdasarkan judul atau penulis dan hanya buku dengan stok > 0
    $query = "SELECT * FROM books 
              WHERE stok > 0 AND (judul LIKE '%$keyword%' OR penulis LIKE '%$keyword%')";
} else {
    // Jika tidak mencari, tampilkan semua buku dengan stok > 0
    $query = "SELECT * FROM books WHERE stok > 0";
}

// Jalankan query dan simpan hasilnya
$buku = mysqli_query($conn, $query);
?>

<!-- Tampilan HTML -->
<h2>Cari Buku</h2>

<!-- Navigasi sederhana -->
<a href="index.php">Kembali</a> | <a href="../auth/logout.php">Logout</a>

<!-- Form pencarian -->
<form method="get">
    <input type="text" name="keyword" placeholder="Cari judul atau penulis" value="<?= htmlspecialchars($keyword); ?>">
    <button type="submit" name="cari">Cari</button>
</form>

<!-- Tabel hasil pencarian -->
<table border="1" cellpadding="8">
    <tr>
        <th>Gambar</th>
        <th>Judul</th>
        <th>Penulis</th>
        <th>Stok</th>
    </tr>

    <!-- Loop hasil pencarian -->
    <?php while ($row = mysqli_fetch_assoc($buku)) : ?>
        <tr>
            <td><img src="../assets/img/<?= htmlspecialchars($row['gambar']); ?>" width="60"></td>
            <td><?= htmlspecialchars($row['judul']); ?></td>
            <td><?= htmlspecialchars($row['penulis']); ?></td>
            <td><?= $row['stok']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>
