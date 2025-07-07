<?php
require '../config/koneksi.php'; // Mengimpor file koneksi ke database

// Mengecek apakah tombol "kembalikan" diklik (form disubmit)
if (isset($_POST['kembalikan'])) {
    $id = $_POST['id_peminjaman']; // Mengambil ID peminjaman dari input tersembunyi (hidden input)

    // Mengubah status peminjaman menjadi 'pending' di database
    mysqli_query($conn, "UPDATE peminjaman SET status = 'pending' WHERE id_peminjaman = $id");

    // Mengalihkan pengguna ke halaman daftar buku yang sedang dipinjam
    header("Location: ../user/dipinjam.php");
    exit; // Menghentikan eksekusi script setelah redirect
}
