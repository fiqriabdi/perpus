<?php
// Informasi koneksi
$conn = mysqli_connect("localhost", "root", "", "perpus");

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query untuk membuat tabel books
$queryBooks = "
CREATE TABLE IF NOT EXISTS books (
    id_buku INT(11) NOT NULL AUTO_INCREMENT,
    gambar VARCHAR(255),
    judul VARCHAR(100),
    penulis VARCHAR(100),
    stok INT(11) DEFAULT 0,
    PRIMARY KEY (id_buku)
);
";

// Query untuk membuat tabel users
$queryUsers = "
CREATE TABLE IF NOT EXISTS users (
    id_users INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(100),
    role ENUM('admin', 'user') DEFAULT 'user',
    PRIMARY KEY (id_users)
);
";

// Query untuk membuat tabel peminjaman
$queryPeminjaman = "
CREATE TABLE IF NOT EXISTS peminjaman (
    id_peminjaman INT(11) NOT NULL AUTO_INCREMENT,
    id_buku INT(11),
    id_users INT(11),
    tgl_pinjam DATE DEFAULT CURDATE(),
    tgl_balik VARCHAR(15) DEFAULT '-',
    status ENUM('dipinjam', 'dikembalikan', 'pending') DEFAULT 'pending',
    PRIMARY KEY (id_peminjaman),
    FOREIGN KEY (id_buku) REFERENCES books(id_buku),
    FOREIGN KEY (id_users) REFERENCES users(id_users)
);
";

// Eksekusi query satu per satu
if (mysqli_query($conn, $queryBooks)) {
    echo "Tabel 'books' berhasil dibuat.<br>";
} else {
    echo "Gagal membuat tabel 'books': " . mysqli_error($conn) . "<br>";
}

if (mysqli_query($conn, $queryUsers)) {
    echo "Tabel 'users' berhasil dibuat.<br>";
} else {
    echo "Gagal membuat tabel 'users': " . mysqli_error($conn) . "<br>";
}

if (mysqli_query($conn, $queryPeminjaman)) {
    echo "Tabel 'peminjaman' berhasil dibuat.<br>";
} else {
    echo "Gagal membuat tabel 'peminjaman': " . mysqli_error($conn) . "<br>";
}

// Tutup koneksi
mysqli_close($conn);
?>
