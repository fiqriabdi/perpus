<?php
// Membuat koneksi ke database MySQL
$conn = mysqli_connect("localhost", "root", "", "perpus");

// Mengecek apakah koneksi berhasil
if (!$conn) {
    // Jika koneksi gagal, tampilkan pesan error dan hentikan eksekusi
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
