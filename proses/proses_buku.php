<?php
require '../config/koneksi.php';

function tambahBuku($data, $file)
{
    global $conn;
    $judul   = $data['judul'];
    $penulis = $data['penulis'];
    $stok    = $data['stok'];
    $des = $data['deskripsi'];
    


    // Upload gambar
    $gambar = $file['gambar']['name'];
    $tmp    = $file['gambar']['tmp_name'];
    move_uploaded_file($tmp, "../assets/img/$gambar");

    // Insert ke database
    $query = "INSERT INTO books (gambar, judul, penulis, deskripsi, stok) 
              VALUES ('$gambar', '$judul', '$penulis', '$des', $stok)";
    return mysqli_query($conn, $query);
}

function editBuku($data, $file)
{
    global $conn;
    $id         = $data['id_buku'];
    $judul      = $data['judul'];
    $penulis    = $data['penulis'];
    $stok       = $data['stok'];
    $gambarLama = $data['gambar_lama'];
    $des = $data['deskripsi'];

    // Cek gambar baru
    if ($file['gambar']['name'] != '') {
        $gambarBaru = $file['gambar']['name'];
        $tmp        = $file['gambar']['tmp_name'];
        move_uploaded_file($tmp, "../assets/img/" . $gambarBaru);
        $gambar = $gambarBaru;
    } else {
        $gambar = $gambarLama;
    }

    // Update data buku
    $query = "UPDATE books SET 
                judul='$judul', 
                penulis='$penulis', 
                deskripsi='$des',
                stok=$stok, 
                gambar='$gambar' 
              WHERE id_buku=$id";
    return mysqli_query($conn, $query);
}

function hapusBuku($id)
{
    global $conn;
    $query = "DELETE FROM books WHERE id_buku=$id";
    return mysqli_query($conn, $query);
}

// === Eksekusi berdasarkan request ===
if (isset($_POST['tambah'])) {
    if (tambahBuku($_POST, $_FILES)) {
        header("Location: ../admin/");
        exit;
    }
}

if (isset($_POST['edit'])) {
    if (editBuku($_POST, $_FILES)) {
        header("Location: ../admin/kelola_buku.php");
        exit;
    }
}

if (isset($_GET['hapus'])) {
    if (hapusBuku($_GET['hapus'])) {
        header("Location: ../admin/");
        exit;
    }
}
