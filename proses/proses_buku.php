<?php
require '../config/koneksi.php'; // Menghubungkan file dengan database melalui koneksi

// Fungsi untuk menambah buku baru
function tambahBuku($data, $file)
{
    global $conn; // Mengakses koneksi dari luar fungsi
    $judul   = $data['judul'];        // Menyimpan judul dari form
    $penulis = $data['penulis'];      // Menyimpan penulis dari form
    $stok    = $data['stok'];         // Menyimpan stok dari form
    $des     = $data['deskripsi'];    // Menyimpan deskripsi dari form

    // Upload gambar buku
    $gambar = $file['gambar']['name'];           // Nama file gambar
    $tmp    = $file['gambar']['tmp_name'];       // File sementara
    move_uploaded_file($tmp, "../assets/img/$gambar"); // Pindahkan file ke folder tujuan

    // Query insert ke tabel books
    $query = "INSERT INTO books (gambar, judul, penulis, deskripsi, stok) 
              VALUES ('$gambar', '$judul', '$penulis', '$des', $stok)";
    return mysqli_query($conn, $query); // Jalankan query dan kembalikan hasilnya
}

// Fungsi untuk mengedit buku yang sudah ada
function editBuku($data, $file)
{
    global $conn;
    $id         = $data['id_buku'];       // ID buku yang akan diedit
    $judul      = $data['judul'];         // Judul baru
    $penulis    = $data['penulis'];       // Penulis baru
    $stok       = $data['stok'];          // Stok baru
    $gambarLama = $data['gambar_lama'];   // Gambar lama
    $des        = $data['deskripsi'];     // Deskripsi baru

    // Cek apakah pengguna mengunggah gambar baru
    if ($file['gambar']['name'] != '') {
        $gambarBaru = $file['gambar']['name'];
        $tmp        = $file['gambar']['tmp_name'];
        move_uploaded_file($tmp, "../assets/img/" . $gambarBaru);
        $gambar = $gambarBaru; // Gunakan gambar baru
    } else {
        $gambar = $gambarLama; // Jika tidak ada gambar baru, pakai gambar lama
    }

    // Query update ke database
    $query = "UPDATE books SET 
                judul='$judul', 
                penulis='$penulis', 
                deskripsi='$des',
                stok=$stok, 
                gambar='$gambar' 
              WHERE id_buku=$id";
    return mysqli_query($conn, $query); // Jalankan query update
}

// Fungsi untuk menghapus buku berdasarkan id
function hapusBuku($id)
{
    global $conn;
    $query = "DELETE FROM books WHERE id_buku=$id"; // Query hapus
    return mysqli_query($conn, $query);
}

// ======= Aksi berdasarkan permintaan pengguna =======

// Jika tombol tambah ditekan
if (isset($_POST['tambah'])) {
    if (tambahBuku($_POST, $_FILES)) {
        header("Location: ../admin/"); // Redirect ke halaman admin jika sukses
        exit;
    }
}

// Jika tombol edit ditekan
if (isset($_POST['edit'])) {
    if (editBuku($_POST, $_FILES)) {
        header("Location: ../admin/kelola_buku.php"); // Redirect ke halaman kelola
        exit;
    }
}

// Jika ada parameter hapus di URL (GET)
if (isset($_GET['hapus'])) {
    if (hapusBuku($_GET['hapus'])) {
        header("Location: ../admin/"); // Redirect setelah berhasil hapus
        exit;
    }
}
