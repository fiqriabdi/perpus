<?php
session_start();

// Jika sudah login, arahkan sesuai role
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/");
        exit;
    } elseif ($_SESSION['role'] == 'user') {
        header("Location: user/");
        exit;
    }
}

// Jika belum login, arahkan ke login
header("Location: auth/dashboard.php");
exit;

