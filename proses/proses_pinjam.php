<?php
session_start(); // Memulai session

require '../config/koneksi.php'; // Mengimpor koneksi ke database

// Cek apakah user sudah login
if (!isset($_SESSION['id_users'])) {
    header("Location: ../auth/login.php"); // Redirect ke halaman login jika belum login
    exit;
}

// Cek apakah tombol pinjam diklik
if (isset($_POST['pinjam'])) {
    $id_buku = $_POST['id_buku']; // Ambil ID buku dari form
    $id_users = $_SESSION['id_users']; // Ambil ID user dari session
    $tgl_pinjam = date("Y-m-d"); // Ambil tanggal hari ini (optional, tidak dipakai karena pakai CURDATE())

    // Ambil stok buku berdasarkan ID
    $cek = mysqli_query($conn, "SELECT stok FROM books WHERE id_buku = $id_buku");
    $data = mysqli_fetch_assoc($cek); // Ambil hasil query

    // Jika stok tersedia
    if ($data && $data['stok'] > 0) {
        // Tambahkan data peminjaman ke tabel 'peminjaman' dengan status 'dipinjam'
        mysqli_query($conn, "INSERT INTO peminjaman (id_buku, id_users, tgl_pinjam, status) 
                             VALUES ($id_buku, $id_users, CURDATE(), 'dipinjam')");

        // Kurangi stok buku
        mysqli_query($conn, "UPDATE books SET stok = stok - 1 WHERE id_buku = $id_buku");

        // Redirect ke halaman utama user setelah berhasil pinjam
        header("Location: ../user/index.php");
        exit;
    } else {
        // Jika stok habis
        echo "Stok buku habis.";
    }
}
