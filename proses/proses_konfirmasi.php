<?php
require '../config/koneksi.php'; // Mengimpor file koneksi ke database

// Mengecek apakah tombol "konfirmasi" diklik (form disubmit)
if (isset($_POST['konfirmasi'])) {
    $id = $_POST['id_peminjaman']; // Mengambil ID peminjaman dari form

    // Mengambil ID buku yang dipinjam berdasarkan ID peminjaman
    $get = mysqli_query($conn, "SELECT id_buku FROM peminjaman WHERE id_peminjaman = $id");
    $data = mysqli_fetch_assoc($get);
    $id_buku = $data['id_buku']; // Menyimpan ID buku

    // Update status peminjaman menjadi 'dikembalikan' dan catat tanggal pengembalian (hari ini)
    mysqli_query($conn, "UPDATE peminjaman 
                         SET status = 'dikembalikan', tgl_balik = CURDATE() 
                         WHERE id_peminjaman = $id");

    // Menambahkan stok buku karena telah dikembalikan
    mysqli_query($conn, "UPDATE books SET stok = stok + 1 WHERE id_buku = $id_buku");

    // Redirect ke halaman konfirmasi admin setelah proses selesai
    header("Location: ../admin/konfirmasi.php");
    exit; // Menghentikan eksekusi script setelah redirect
}
