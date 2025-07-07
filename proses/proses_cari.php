<?php
require '../config/koneksi.php'; // Mengimpor file koneksi ke database

// Inisialisasi variabel untuk menyimpan hasil pencarian dan input pencarian
$hasil = [];       // Untuk menyimpan hasil query
$keyword = '';     // Kata kunci pencarian
$kolom = '';       // Kolom yang akan dicari (judul, penulis, atau semua)

// Mengecek apakah form dikirim dengan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengamankan input dari SQL Injection
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']); // Kata kunci dicari dari form
    $kolom = $_POST['kolom']; // Nama kolom yang dipilih user untuk pencarian

    // Menentukan query berdasarkan kolom yang dipilih
    if ($kolom === 'judul') {
        $query = "SELECT * FROM books WHERE judul LIKE '%$keyword%'"; // Cari berdasarkan judul
    } elseif ($kolom === 'penulis') {
        $query = "SELECT * FROM books WHERE penulis LIKE '%$keyword%'"; // Cari berdasarkan penulis
    } elseif ($kolom === 'isbn') {
        // Kolom ISBN belum tersedia, fallback cari di judul atau penulis
        $query = "SELECT * FROM books WHERE judul LIKE '%$keyword%' OR penulis LIKE '%$keyword%'";
    } else {
        // Jika kolom tidak dipilih, cari di semua kolom yang tersedia (judul dan penulis)
        $query = "SELECT * FROM books 
                  WHERE judul LIKE '%$keyword%' 
                  OR penulis LIKE '%$keyword%'";
    }

    // Jalankan query dan simpan hasilnya ke dalam variabel $hasil
    $hasil = mysqli_query($conn, $query);
}
?>
