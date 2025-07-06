<?php
require '../config/koneksi.php';

if (isset($_POST['konfirmasi'])) {
    $id = $_POST['id_peminjaman'];

    // Ambil id_buku-nya
    $get = mysqli_query($conn, "SELECT id_buku FROM peminjaman WHERE id_peminjaman = $id");
    $data = mysqli_fetch_assoc($get);
    $id_buku = $data['id_buku'];

    // Ubah status dan isi tgl_balik
    mysqli_query($conn, "UPDATE peminjaman 
                         SET status = 'dikembalikan', tgl_balik = CURDATE() 
                         WHERE id_peminjaman = $id");

    // Tambah stok kembali
    mysqli_query($conn, "UPDATE books SET stok = stok + 1 WHERE id_buku = $id_buku");

    header("Location: ../admin/konfirmasi.php");
    exit;
}
