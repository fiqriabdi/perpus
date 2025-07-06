<?php
require '../config/koneksi.php';

if (isset($_POST['kembalikan'])) {
    $id = $_POST['id_peminjaman'];
    mysqli_query($conn, "UPDATE peminjaman SET status = 'pending' WHERE id_peminjaman = $id");
    header("Location: ../user/dipinjam.php");
    exit;
}