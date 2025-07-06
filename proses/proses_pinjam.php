<?php
session_start();
require '../config/koneksi.php';

if (!isset($_SESSION['id_users'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_POST['pinjam'])) {
    $id_buku = $_POST['id_buku'];
    $id_users = $_SESSION['id_users'];
    $tgl_pinjam = date("Y-m-d");

    // Cek stok
    $cek = mysqli_query($conn, "SELECT stok FROM books WHERE id_buku = $id_buku");
    $data = mysqli_fetch_assoc($cek);

    if ($data && $data['stok'] > 0) {
        // Tambah peminjaman dengan status langsung 'dipinjam'
        mysqli_query($conn, "INSERT INTO peminjaman (id_buku, id_users, tgl_pinjam, status) 
                             VALUES ($id_buku, $id_users, CURDATE(), 'dipinjam')");

        // Kurangi stok
        mysqli_query($conn, "UPDATE books SET stok = stok - 1 WHERE id_buku = $id_buku");

        header("Location: ../user/index.php");
        exit;
    } else {
        echo "Stok buku habis.";
    }
}
