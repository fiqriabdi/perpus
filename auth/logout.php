<?php
session_start();           // Memulai sesi agar bisa mengakses data sesi saat ini
session_destroy();         // Menghapus semua data sesi (logout user)
header("Location: dashboard.php"); // Redirect ke halaman dashboard (umumnya halaman utama non-login)
exit;                      // Menghentikan eksekusi script setelah redirect
?>
