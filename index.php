<?php
session_start(); // Mulai session

// Jika user sudah login
if (isset($_SESSION['role'])) {
    // Jika role-nya admin, arahkan ke folder admin
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/");
        exit;
    }
    // Jika role-nya user, arahkan ke folder user
    elseif ($_SESSION['role'] == 'user') {
        header("Location: user/");
        exit;
    }
}

// Jika belum login, arahkan ke halaman login
header("Location: auth/dashboard.php");
exit;
