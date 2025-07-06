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
              WHERE stok > 0 AND (judul LIKE '%$keyword%' OR penulis LIKE '%$keyword%')";
} else {
    $query = "SELECT * FROM books WHERE stok > 0";
}
$buku = mysqli_query($conn, $query);
?>

<h2>Cari Buku</h2>
<a href="index.php">Kembali</a> | <a href="../auth/logout.php">Logout</a>

<form method="get">
    <input type="text" name="keyword" placeholder="Cari judul atau penulis" value="<?= htmlspecialchars($keyword); ?>">
    <button type="submit" name="cari">Cari</button>
</form>

<table border="1" cellpadding="8">
    <tr>
        <th>Gambar</th>
        <th>Judul</th>
        <th>Penulis</th>
        <th>Stok</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($buku)) : ?>
        <tr>
            <td><img src="../assets/img/<?= $row['gambar']; ?>" width="60"></td>
            <td><?= $row['judul']; ?></td>
            <td><?= $row['penulis']; ?></td>
            <td><?= $row['stok']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>
