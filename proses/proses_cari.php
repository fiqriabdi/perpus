<?php
require '../config/koneksi.php';

// Inisialisasi
$hasil = [];
$keyword = '';
$kolom = '';

// Proses jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $kolom = $_POST['kolom'];

    if ($kolom === 'judul') {
        $query = "SELECT * FROM books WHERE judul LIKE '%$keyword%'";
    } elseif ($kolom === 'penulis') {
        $query = "SELECT * FROM books WHERE penulis LIKE '%$keyword%'";
    } elseif ($kolom === 'isbn') {
        // Jika nanti ada kolom ISBN, ganti ini
        $query = "SELECT * FROM books WHERE judul LIKE '%$keyword%' OR penulis LIKE '%$keyword%'";
    } else {
        // Semua kolom
        $query = "SELECT * FROM books 
                  WHERE judul LIKE '%$keyword%' 
                  OR penulis LIKE '%$keyword%'";
    }

    $hasil = mysqli_query($conn, $query);
}
?>
